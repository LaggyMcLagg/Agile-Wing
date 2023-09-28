<?php

namespace App\Http\Controllers;

use App\CourseClass;
use Illuminate\Http\Request;

class CourseClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /*public function index()
    {
        $courseClasses = CourseClass::all();

        return view('pages.course_classes.indexForScheduleAtribution', compact('courseClasses'));
    }*/

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  \App\CourseClass  $courseClass
     * @return \Illuminate\Http\Response
     */
    public function show(CourseClass $courseClass)
    {
        // Eager load the necessary relationships
        $courseClass->load('course', 'scheduleAtributions', 'hourBlockCourseClasses');

        // Pass the data to the view
        return view('pages.course_classes.showForScheduleAtribution', compact('courseClass'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CourseClass  $courseClass
     * @return \Illuminate\Http\Response
     */
    public function edit(CourseClass $courseClass)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CourseClass  $courseClass
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CourseClass $courseClass)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CourseClass  $courseClass
     * @return \Illuminate\Http\Response
     */
    public function destroy(CourseClass $courseClass)
    {

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexForScheduleAtribution()
    {
        $courseClasses = CourseClass::with('course.specializationArea')->get();
        return view('pages.course_classes.indexForScheduleAtribution', compact ('courseClasses'));
    }
    //fazer as rotas assim como estão aqui

    /**
     * Display schedule information.
     */
    public function showForScheduleAtribution(CourseClass $courseClass)
    {
        $courseClass->load('course', 'scheduleAtributions', 'hourBlockCourseClasses');
        $scheduleAtributions = $courseClass->scheduleAtributions()->get();
        return view('pages.course_classes.showForScheduleAtribution', compact ('courseClass', 'scheduleAtributions'));
    }

}
