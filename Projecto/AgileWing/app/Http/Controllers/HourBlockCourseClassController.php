<?php

namespace App\Http\Controllers;

use App\CourseClass;
use App\HourBlockCourseClass;
use Illuminate\Http\Request;

class HourBlockCourseClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Fetch all teacher availabilities along with the related information
        $hourBlockCourseClasses = HourBlockCourseClass::with('courseClass')->get();

        // Pass the data to the view
        return view('pages.hour-block-course-classes.index', compact('hourBlockCourseClasses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $courseClasses = CourseClass::all();
        
        return view('pages.hour-block-course-classes.create', [
            'courseClasses' => $courseClasses
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate($request, [
            'course_class_id' => 'required|exists:courseClasses,id',
            'hour_beginning' => 'required|regex:/^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]$/',
            'hour_end' => 'required|regex:/^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]$/'
        ]);
    
        HourBlockCourseClass::create($request->all());
        return redirect()->route('hour-block-course-classes.index')->with('success', 'Hour Block Course Class created successfully');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\HourBlockCourseClass  $hourBlockCourseClass
     * @return \Illuminate\Http\Response
     */
    public function show(HourBlockCourseClass $hourBlockCourseClass)
    {
        $hourBlockCourseClass->load('courseClass');
        
        // Pass the data to the view
        return view('pages.hour-block-course-classes.show', compact('hourBlockCourseClass'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\HourBlockCourseClass  $hourBlockCourseClass
     * @return \Illuminate\Http\Response
     */
    public function edit(HourBlockCourseClass $hourBlockCourseClass)
    {
        $courseClasses = CourseClass::all();
        
        return view('pages.hour-block-course-classes.edit', compact('hourBlockCourseClass', 'courseClasses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\HourBlockCourseClass  $hourBlockCourseClass
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HourBlockCourseClass $hourBlockCourseClass)
    {
        $request->merge(['is_locked' => $request->has('is_locked')]);
    
        $request->validate([
            'course_class_id' => 'required|exists:users,id',
            'hour-beginning' => 'required|regex:/^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]$/',
            'hour_end' => 'required|regex:/^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]$/'
        ]);
    
        $hourBlockCourseClass->update($request->all());
    
        return redirect()->route('hour-block-course-classes.store.index')->with('success', 'Hour Block Course Classes updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\HourBlockCourseClass  $hourBlockCourseClass
     * @return \Illuminate\Http\Response
     */
    public function destroy(HourBlockCourseClass $hourBlockCourseClass)
    {
        $hourBlockCourseClass->delete();
    
        return redirect()->route('hour-block-course-classes.index')
                         ->with('success', 'Hour Block Course Class deleted successfully');
    }
}
