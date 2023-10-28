<?php

namespace App\Http\Controllers;

use App\AvailabilityType;
use App\CourseClass;
use App\ScheduleAtribution;
use App\Ufcd;
use App\User;
use App\HourBlockCourseClass;
use App\Course;
use Illuminate\Http\Request;
use App\Rules\AvailabilityTypeMatchesUser; //custom rule



class ScheduleAtributionController extends Controller
{
    //###############################
    //CRUD METHODS
    //###############################

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($courseClassId)
    {
        // Fetch all schedule attributions related to the given course class ID with associated users
        $courseClass = CourseClass::find($courseClassId);
        $scheduleAtributions = ScheduleAtribution::where('course_class_id', $courseClass->id)
            ->with('user', 'ufcd')
            ->get();

        // Extract users from the schedule attributions, and map only the info needed
        $users = $scheduleAtributions->pluck('user')->unique('id')->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'color_1' => $user->color_1
            ];
        });

        // Extract ufcd from the schedule attributions, and map only the info needed
        $ufcds = $scheduleAtributions->pluck('ufcd')->unique('id')->map(function ($ufcd) {
            return [
                'id' => $ufcd->id,
                'number' => $ufcd->number,
            ];
        });

        //vars for content
        $editNotes = false;
        $userNotes = "";
        $availabilityTypes = "";
        $hourBlocks = HourBlockCourseClass::where('course_class_id', $courseClass->id)->orderBy('hour_beginning', 'asc')->get();

        //var for component setup
        $showExportBtn = true;
        $showNotes = false;
        $showLegend = false;
        $showBtnStore = false;
        $objectName = $courseClass->number . ' - ' . $courseClass->name;
        $jsonCourseClassAtributions = json_encode($scheduleAtributions);
        $jsonUser = json_encode($users);
        $jsonUfcd = json_encode($ufcds);

        return view('pages.schedule_atributions.index',
            compact(
                'userNotes', 
                'availabilityTypes',
                'hourBlocks',
                
                'showExportBtn',
                'showNotes',
                'editNotes',
                'showLegend',
                'showBtnStore',
                'objectName', 
                'jsonUser',
                'jsonUfcd',
                'jsonCourseClassAtributions',
                'courseClassId'
            ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($idCourseClass, $idHourBlockCourseClass, $date)
    {
        //ensure date format
        $dateObject = new \DateTime($date);
        $formattedDate = $dateObject->format('Y-m-d');
        
        //get the object course class from the idCourseClass
        $courseClass = CourseClass::findOrFail($idCourseClass);

        //get the object hourblock course class idHourBlockCourseClass
        $hourBlockCourseClass = HourBlockCourseClass::findOrFail($idHourBlockCourseClass);

        //get all the ufcds of this idCourseClass via the course
        $ufcds = $courseClass->course->ufcds;

        //get all the users that have the same ufcds as courseClass course, and eager load their teacher availabilities
        //filter dy date and type
        $usersWithSameUfcds = User::whereHas('ufcds', function ($query) use ($ufcds) {
            $query->whereIn('ufcds.id', $ufcds->pluck('id'));
        })->with(['teacherAvailabilities' => function ($query) use ($formattedDate) {
            $query  
                ->where('availability_date', $formattedDate)
                ->whereIn('availability_type_id', [2, 3, 4])
                ->with('availabilityType');
        }])->get();

        $usersAvailableOnDate = $usersWithSameUfcds->filter(function ($user) {
            return $user->teacherAvailabilities->isNotEmpty();
        });

        $filteredUsers = $usersAvailableOnDate->filter(function ($user) use ($hourBlockCourseClass) {
            // fetch all the hour blocks where the user is available
            $availableHourBlocks = $user->teacherAvailabilities->pluck('hourBlock');
            
            // Check if the user has any availability that envelops the hour block of the course class
            foreach ($availableHourBlocks as $hourBlock) {
                if ($hourBlock->hour_beginning <= $hourBlockCourseClass->hour_beginning 
                && $hourBlock->hour_end >= $hourBlockCourseClass->hour_end) {
                    return true;
                }
            }
            
            return false;
        });

        //for the js on cliente side to work
        $usersWithUfcdsJson = $filteredUsers->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'ufcd_ids' => $user->ufcds->pluck('id')->toArray(),
            ];
        })->toJson();

        // Transform the filtered users by processing each one of them.
        $processedUsers = $filteredUsers->map(function ($user) use ($hourBlockCourseClass) {
            // For each user, find the first availability that matches the criteria defined within the inner function.
            $matchingAvailability = $user->teacherAvailabilities->first(function ($availability) use ($hourBlockCourseClass) {
                
                // Extract the hour block from the current availability.
                $hourBlock = $availability->hourBlock;

                // Check if the hour block of the current availability matches the hour block of the course class
                return $hourBlock->hour_beginning <= $hourBlockCourseClass->hour_beginning 
                    && $hourBlock->hour_end >= $hourBlockCourseClass->hour_end;
            });

            // Return a new array for each user containing:
            return [
                'id' => $user->id,
                'name' => $user->name,
                'matchingAvailability' => $matchingAvailability
            ];
        })->all(); // Convert the resulting collection to an PHP array.

        
        
        return view('pages.schedule_atributions.create', 
            compact(
                'courseClass', 
                'hourBlockCourseClass', 
                'ufcds', 
                'processedUsers', 
                'date',
                'usersWithUfcdsJson'
        ));
    }

/**
 * Store a newly created resource in storage.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */
public function store(Request $request)
{
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'ufcd_id' => 'required|exists:ufcds,id',
        'course_class_id' => 'required|exists:course_classes,id',
        'availability_type_id' => ['required', 'exists:availability_types,id', new AvailabilityTypeMatchesUser($request->user_id)],
        'hour_block_course_class_id' => 'required|exists:hour_block_course_classes,id',
        'date' => 'required|date_format:Y-m-d',
        'presencial' => 'nullable|boolean'
    ], [
        'user_id.required' => 'É obrigatório seleccionar um formador.',
        'user_id.exists' => 'O formador selecionado não é válido.',
    
        'ufcd_id.required' => 'É obrigatório seleccionar uma UFCD.',
        'ufcd_id.exists' => 'A UFCD selecionado não é válida.',
    
        'course_class_id.required' => 'O campo turma é obrigatório.',
        'course_class_id.exists' => 'A turma selecionada não é válida.',
    
        'availability_type_id.required' => 'O campo tipo de disponibilidade é obrigatório.',
        'availability_type_id.exists' => 'O tipo de disponibilidade selecionado não é válido.',
    
        'hour_block_course_class_id.required' => 'O campo bloco de horas da turma é obrigatório.',
        'hour_block_course_class_id.exists' => 'O bloco de horas da turma selecionado não é válido.',
    
        'date.required' => 'O campo data é obrigatório.',
        'date.date_format' => 'O formato da data é inválido. O formato correto é AAAA-MM-DD.',
    
        'presencial.boolean' => 'O valor do campo presencial é inválido.'
    ]);
    

    $scheduleAtribution = ScheduleAtribution::create($request->all());

    return redirect()->route('schedule-atribution.index', ['courseClassId' => $request['course_class_id']])->with('success', 'Agendado com sucesso!');
}


    /**
     * Display the specified resource.
     *
     * @param  \App\ScheduleAtribution  $scheduleAtribution
     * @return \Illuminate\Http\Response
     */
    public function show(ScheduleAtribution $scheduleAtribution)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ScheduleAtribution  $scheduleAtribution
     * @return \Illuminate\Http\Response
     */
    public function edit($scheduleAtributionId, $courseClassId)
    {

        $scheduleAtribution = ScheduleAtribution::find($scheduleAtributionId);

        //ensure date format
        $dateObject = new \DateTime($scheduleAtribution->date);
        $date = $dateObject->format('Y-m-d');
        
        //get the object course class from the idCourseClass
        $courseClass = CourseClass::findOrFail($courseClassId);

        //get the object hourblock course class idHourBlockCourseClass
        $hourBlockCourseClass = HourBlockCourseClass::findOrFail($scheduleAtribution->hour_block_course_class_id);

        //get all the ufcds of this idCourseClass via the course
        $ufcds = $courseClass->course->ufcds;

        //get all the users that have the same ufcds as courseClass course, and eager load their teacher availabilities
        //filter dy date and type
        $usersWithSameUfcds = User::whereHas('ufcds', function ($query) use ($ufcds) {
            $query->whereIn('ufcds.id', $ufcds->pluck('id'));
        })->with(['teacherAvailabilities' => function ($query) use ($date) {
            $query  
                ->where('availability_date', $date)
                ->whereIn('availability_type_id', [2, 3, 4])
                ->with('availabilityType');
        }])->get();

        $usersAvailableOnDate = $usersWithSameUfcds->filter(function ($user) {
            return $user->teacherAvailabilities->isNotEmpty();
        });

        $filteredUsers = $usersAvailableOnDate->filter(function ($user) use ($hourBlockCourseClass) {
            // fetch all the hour blocks where the user is available
            $availableHourBlocks = $user->teacherAvailabilities->pluck('hourBlock');
            
            // Check if the user has any availability that envelops the hour block of the course class
            foreach ($availableHourBlocks as $hourBlock) {
                if ($hourBlock->hour_beginning <= $hourBlockCourseClass->hour_beginning 
                && $hourBlock->hour_end >= $hourBlockCourseClass->hour_end) {
                    return true;
                }
            }
            
            return false;
        });

        //for the js on cliente side to work
        $usersWithUfcdsJson = $filteredUsers->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'ufcd_ids' => $user->ufcds->pluck('id')->toArray(),
            ];
        })->toJson();

        // Transform the filtered users by processing each one of them.
        $processedUsers = $filteredUsers->map(function ($user) use ($hourBlockCourseClass) {
            // For each user, find the first availability that matches the criteria defined within the inner function.
            $matchingAvailability = $user->teacherAvailabilities->first(function ($availability) use ($hourBlockCourseClass) {
                
                // Extract the hour block from the current availability.
                $hourBlock = $availability->hourBlock;

                // Check if the hour block of the current availability matches the hour block of the course class
                return $hourBlock->hour_beginning <= $hourBlockCourseClass->hour_beginning 
                    && $hourBlock->hour_end >= $hourBlockCourseClass->hour_end;
            });

            // Return a new array for each user containing:
            return [
                'id' => $user->id,
                'name' => $user->name,
                'matchingAvailability' => $matchingAvailability
            ];
        })->all(); // Convert the resulting collection to an PHP array.

        
        
        return view('pages.schedule_atributions.edit', 
            compact(
                'courseClass', 
                'hourBlockCourseClass', 
                'ufcds', 
                'processedUsers', 
                'date',
                'usersWithUfcdsJson',
                'scheduleAtribution'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ScheduleAtribution  $scheduleAtribution
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'ufcd_id' => 'required|exists:ufcds,id',
            'course_class_id' => 'required|exists:course_classes,id',
            'availability_type_id' => ['required', 'exists:availability_types,id', new AvailabilityTypeMatchesUser($request->user_id)],
            'hour_block_course_class_id' => 'required|exists:hour_block_course_classes,id',
            'date' => 'required|date_format:Y-m-d',
            'presencial' => 'nullable|boolean'
        ], [
            'user_id.required' => 'É obrigatório seleccionar um formador.',
            'user_id.exists' => 'O formador selecionado não é válido.',
        
            'ufcd_id.required' => 'É obrigatório seleccionar uma UFCD.',
            'ufcd_id.exists' => 'A UFCD selecionado não é válida.',
        
            'course_class_id.required' => 'O campo turma é obrigatório.',
            'course_class_id.exists' => 'A turma selecionada não é válida.',
        
            'availability_type_id.required' => 'O campo tipo de disponibilidade é obrigatório.',
            'availability_type_id.exists' => 'O tipo de disponibilidade selecionado não é válido.',
        
            'hour_block_course_class_id.required' => 'O campo bloco de horas da turma é obrigatório.',
            'hour_block_course_class_id.exists' => 'O bloco de horas da turma selecionado não é válido.',
        
            'date.required' => 'O campo data é obrigatório.',
            'date.date_format' => 'O formato da data é inválido. O formato correto é AAAA-MM-DD.',
        
            'presencial.boolean' => 'O valor do campo presencial é inválido.'
        ]);
        
        $scheduleAtribution = ScheduleAtribution::find($id);
    
        $scheduleAtribution->update($request->all());
    
        return redirect()->route('schedule-atribution.index', ['courseClassId' => $request['course_class_id']])->with('success', 'Agendamento alterado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ScheduleAtribution  $scheduleAtribution
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $courseClassId)
    {
        $scheduleAtribution = ScheduleAtribution::find($id);

        $scheduleAtribution->delete();
        
        return redirect()->route('schedule-atribution.index', $courseClassId)->with('success', 'Agendamento apagado com sucesso!');
    }
    

    //###############################
    //OTHER METHODS
    //###############################

}

