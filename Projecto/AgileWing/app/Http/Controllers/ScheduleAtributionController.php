<?php

namespace App\Http\Controllers;

use App\AvailabilityType;
use App\CourseClass;
use App\ScheduleAtribution;
use App\Ufcd;
use App\User;
use App\HourBlockCourseClass;
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
    public function index($id)
    {
        // Fetch all schedule attributions related to the given course class ID with associated users
        $courseClass = CourseClass::find($id);
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
        $courseClass = CourseClass::find($id);
        $editNotes = false;
        $courseClassId = $courseClass->id;
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

        return view('pages.schedule_atribution.index',
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

    //###############################
    //OTHER METHODS
    //###############################

}

