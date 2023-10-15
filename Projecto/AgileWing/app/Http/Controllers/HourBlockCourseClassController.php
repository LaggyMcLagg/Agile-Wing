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

        $courseClasses = CourseClass::all();

        // Pass the data to the view
        return view('pages.hour_block_course_classes.crud', compact('hourBlockCourseClasses', 'courseClasses'));
    }

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
        $request->validate(
            [
                'course_class_id' => 'required|exists:course_classes,id',
                'hour_beginning' => 'required|date_format:H:i:s|before:hour_end',
                'hour_end' => 'required|date_format:H:i:s|after:hour_beginning',
            ],
            [
                'course_class_id.required' => 'The course class field is required.',
                'course_class_id.exists' => 'The selected course class is invalid.',
                'hour_beginning.required' => 'The hour beginning field is required.',
                'hour_beginning.date_format' => 'The hour beginning must be in the format hh:mm:ss.',
                'hour_beginning.before' => 'The hour beginning must be before the hour end.',
                'hour_end.required' => 'The hour end field is required.',
                'hour_end.date_format' => 'The hour end must be in the format hh:mm:ss.',
                'hour_end.after' => 'The hour end must be after the hour beginning.',
            ]
        );        
    
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\HourBlockCourseClass  $hourBlockCourseClass
     * @return \Illuminate\Http\Response
     */
    public function edit(HourBlockCourseClass $hourBlockCourseClass)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\HourBlockCourseClass  $hourBlockCourseClass
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $hourBlockCourseClass = HourBlockCourseClass::find($id);

        $request->validate(
            [
                'course_class_id' => 'required|exists:course_classes,id',
                'hour_beginning' => 'required|date_format:H:i:s|before:hour_end',
                'hour_end' => 'required|date_format:H:i:s|after:hour_beginning',
            ],
            [
                'course_class_id.required' => 'The course class field is required.',
                'course_class_id.exists' => 'The selected course class is invalid.',
                'hour_beginning.required' => 'The hour beginning field is required.',
                'hour_beginning.date_format' => 'The hour beginning must be in the format hh:mm:ss.',
                'hour_beginning.before' => 'The hour beginning must be before the hour end.',
                'hour_end.required' => 'The hour end field is required.',
                'hour_end.date_format' => 'The hour end must be in the format hh:mm:ss.',
                'hour_end.after' => 'The hour end must be after the hour beginning.',
            ]
        );        
    
        $hourBlockCourseClass->update($request->all());
    
        return redirect()->route('hour-block-course-classes.index')->with('success', 'Hour Block Course Classes updated successfully');
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
