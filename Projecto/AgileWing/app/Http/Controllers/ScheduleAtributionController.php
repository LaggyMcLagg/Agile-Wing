<?php

namespace App\Http\Controllers;

use App\AvailabilityType;
use App\CourseClass;
use App\ScheduleAtribution;
use App\Ufcd;
use App\User;
use Illuminate\Http\Request;

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
    public function create(CourseClass $courseClass)
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
    public function store(Request $request, CourseClass $courseClass)
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
    public function show(CourseClass $courseClass, ScheduleAtribution $scheduleAtribution)
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
    public function edit(CourseClass $courseClass, ScheduleAtribution $scheduleAtribution)
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
    public function update(Request $request, CourseClass $courseClass, ScheduleAtribution $scheduleAtribution)
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
    public function destroy(CourseClass $courseClass, ScheduleAtribution $scheduleAtribution)
    {
        $scheduleAtribution->delete();

        return redirect()->route('schedule_atribution.index', $courseClass);
    }
}

