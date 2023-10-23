<?php

namespace App\Http\Controllers;

use App\AvailabilityType;
use App\CourseClass;
use App\ScheduleAtribution;
use App\Ufcd;
use App\User;
use Illuminate\Http\Request;
//cronogramaPDF
use App\HourBlockCourseClass;
use App\HourBlock;
use Carbon\Carbon;


class ScheduleAtributionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CourseClass $courseClass)
    {
        $scheduleAtributions = ScheduleAtribution::where('course_class_id', $courseClass->id)->get();
            
        return view('pages.schedule_atribution.index', compact('scheduleAtributions'));
    }
    
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(User $user)
    {
        $availabilityTypes = AvailabilityType::all();
        $courseClasses = CourseClass::all();
        $ufcds = Ufcd::all();
        $users = User::all();

        //if($user->user_type_id == 1) { //TODO descomentar
            return view('pages.schedule_atribution.create', compact('availabilityTypes', 'courseClasses', 'ufcds', 'users'));
        //} else {
            //return view('pages.error');
        //}
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        // Validar dados
        $request->validate([
            'date' => 'required|date|after:today',
            'hour_start' => 'required|date_format:H:i',
            'hour_end' => 'required|date_format:H:i',
            'availability_type_id' => 'required|exists:availability_types,id',
            'course_class_id' => 'required|exists:course_classes,id',
            'ufcd_id' => 'required|exists:ufcds,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $scheduleUser = User::find($request->user_id);

        $scheduleUser->scheduleAtributions()->create($request->all());

        return redirect()->route('schedule_atribution.index')->with('status', 'Schedule atribution created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ScheduleAtribution  $scheduleAtribution
     * @return \Illuminate\Http\Response
     */
    public function show(User $user, ScheduleAtribution $scheduleAtribution)
    {
        // Eager load the necessary relationships
        $scheduleAtribution->load('user', 'ufcd', 'courseClass', 'availabilityType');

        // Pass the data to the view
        return view('pages.schedule_atribution.show', compact('scheduleAtribution'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ScheduleAtribution  $scheduleAtribution
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user, ScheduleAtribution $scheduleAtribution)
    {
        $availabilityTypes = AvailabilityType::all();
        $courseClasses = CourseClass::all();
        $ufcds = Ufcd::all();
        $users = User::all();

        return view('pages.schedule_atribution.edit', compact('scheduleAtribution', 'availabilityTypes', 'courseClasses', 'ufcds', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ScheduleAtribution  $scheduleAtribution
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user, ScheduleAtribution $scheduleAtribution)
    {
        $request->validate([
            'date' => 'required|date|after:today',
            'hour_start' => 'required|date_format:H:i',
            'hour_end' => 'required|date_format:H:i',
            'availability_type_id' => 'required|exists:availability_types,id',
            'course_class_id' => 'required|exists:course_classes,id',
            'ufcd_id' => 'required|exists:ufcds,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $scheduleAtribution->update($request->all());

        return redirect()->route('schedule_atribution.index')->with('status', 'Schedule atribution updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ScheduleAtribution  $scheduleAtribution
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, ScheduleAtribution $scheduleAtribution)
    {
        $scheduleAtribution->delete();

        return redirect()->route('schedule_atribution.index', $user);
    }

    public function scheduler()
    {
        //vars for content
        $user = Auth::user();
        $userNotes = $user->notes;
        $availabilityTypes = AvailabilityType::all();
        $hourBlocks = HourBlock::orderBy('hour_beginning', 'asc')->get();
        $teacherAvailabilities = TeacherAvailability::where('user_id', $user->id)->get();
        
        //var for component setup
        $showNotes = true;
        $showLegend = true;
        $showBtnStore = true;
        $objectName = $user->name;
        $jsonTeacherAvailabilities = json_encode($teacherAvailabilities);

        return view('pages.teacher_availabilities.scheduler', 
        compact(
            'userNotes', 
            'availabilityTypes',
            'hourBlocks', 
            'teacherAvailabilities', 

            'showNotes',
            'showLegend',
            'showBtnStore',
            'objectName', 
            'jsonTeacherAvailabilities'
        ));
    }

    public function timelineToPdf()
    {
        $classId = 1;
        $courseClass = CourseClass::with([
            'course',
            'hourBlockCourseClasses', 
            'hourBlockCourseClasses.scheduleAtributions', 
        ])->find($classId);

        //cria uma coleção de atribuições de horário formatadas
        $formattedAtributions = $courseClass->hourBlockCourseClasses->flatMap(function ($hourBlockCourseClass) 
        {
            return $hourBlockCourseClass->scheduleAtributions->map(function ($scheduleAtribution) 
            {
            $scheduleAtribution->formattedDate = $scheduleAtribution->date->format('d/m/Y');
            return $scheduleAtribution;
            });
        });

        $courseInitials = $courseClass->course->initials;

        //para repetir os dias da semana ao longo do número de semanas de duração
        $firstDay = $formattedAtributions->min('date');
        $lastDay = $formattedAtributions->max('date');
        $numberOfWeeks = $firstDay->diffInWeeks($lastDay);

        return view('pages.schedule_atribution.export-pdf', [
            'courseClass' => $courseClass,
            'formattedAtributions' => $formattedAtributions,
            'courseInitials' => $courseInitials,
            'firstDay' => $firstDay,
            'lastDay' => $lastDay,
            'numberOfWeeks' => $numberOfWeeks,
        ]);
    }

    
    
    

}

