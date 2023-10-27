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
                ->whereIn('availability_type_id', [1, 2]);
        }])->get();
        // dd($usersWithSameUfcds);

        $usersAvailableOnDate = $usersWithSameUfcds->filter(function ($user) {
            return $user->teacherAvailabilities->isNotEmpty();
        });
        // dd($usersAvailableOnDate);

        // //#############
        // $usersWithAvailabilitiesArray = $usersAvailableOnDate->map(function ($user) {
        //     return [
        //         'user_id' => $user->id,
        //         'user_name' => $user->name, // Assuming the user model has a 'name' field
        //         'availabilities' => $user->teacherAvailabilities->map(function ($availability) {
        //             return [
        //                 'availability_id' => $availability->id,
        //                 'availability_date' => $availability->availability_date,
        //                 'hour_block' => [
        //                     'hour_beginning' => $availability->hourBlock->hour_beginning,
        //                     'hour_end' => $availability->hourBlock->hour_end,
        //                 ],
        //                 'availability_type_id' => $availability->availability_type_id,
        //                 // ... Any other fields you want from the availability model
        //             ];
        //         })->toArray(),
        //     ];
        // })->toArray();
        
        // // Encode the structured data into JSON
        // $jsonOutput = json_encode($usersWithAvailabilitiesArray, JSON_PRETTY_PRINT);
        // dd($jsonOutput);
        // //############

        $filteredUsers = $usersAvailableOnDate->filter(function ($user) use ($hourBlockCourseClass) {
            // fetch all the hour blocks where the user is available
            $availableHourBlocks = $user->teacherAvailabilities->pluck('hourBlock');
            // dd($availableHourBlocks);
            
            // Check if the user has any availability that envelops the hour block of the course class
            foreach ($availableHourBlocks as $hourBlock) {
                if ($hourBlock->hour_beginning <= $hourBlockCourseClass->hour_beginning 
                && $hourBlock->hour_end >= $hourBlockCourseClass->hour_end) {
                    return true;
                }
            }
            
            return false;
        });
        // dd($filteredUsers);
        
        return view('pages.schedule_atributions.create', 
            compact(
                'courseClass', 
                'hourBlockCourseClass', 
                'ufcds', 
                'filteredUsers', 
                'date'
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
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ScheduleAtribution  $scheduleAtribution
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ScheduleAtribution  $scheduleAtribution
     * @return \Illuminate\Http\Response
     */
    public function destroy($scheduleAtributionId)
    {
       //
    }

    //###############################
    //OTHER METHODS
    //###############################

}

