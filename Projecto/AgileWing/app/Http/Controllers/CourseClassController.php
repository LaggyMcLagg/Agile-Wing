<?php

namespace App\Http\Controllers;

use App\CourseClass;
use App\Course;
use Illuminate\Http\Request;

class CourseClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courseClasses = CourseClass::with('course', 'hourBlockCourseClasses')->get();

        $courses = Course::all();

        return view('pages.course_classes.crud',  compact('courseClasses', 'courses'));
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
        $request->validate([
            'name' => 'required|string|max:255|regex:/^[\pL\sÇç]+$/u',
            'number' => 'required|string|regex:/^\d{2}\.\d{2}$/',
            'course_id' => 'required|exists:courses,id',
        ],
        [
            'number.required' => 'The number field is required.',
            'number.regex' => 'The number should be in the format XX.XX (e.g., 12.34).',
            'number.unique' => 'The provided number already exists.',
            'name.required' => 'The name field is required.',
            'name.regex' => 'The name may only contain letters, accentuation, and Ç or ç.',
        ]);

        CourseClass::create($request->all());

        return redirect()->route('course-classes.index')->with('success', 'Item created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CourseClass  $courseClass
     * @return \Illuminate\Http\Response
     */
    public function show(CourseClass $courseClass)
    {
        //
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
    public function update(Request $request, $id)
    {    
        $courseClass = CourseClass::find($id);

        $request->validate([
            'name' => 'required|string|max:255|regex:/^[\pL\sÇç]+$/u',
            'number' => 'required|string|regex:/^\d{2}\.\d{2}$/u',
            'course_id' => 'required|exists:courses,id',
        ],
        [
            'number.required' => 'The number field is required.',
            'number.regex' => 'The number should be in the format XX.XX (e.g., 12.34).',
            'number.unique' => 'The provided number already exists.',
            'name.required' => 'The name field is required.',
            'name.regex' => 'The name may only contain letters, accentuation, and Ç or ç.',
        ]);
    
        $courseClass->update($request->all());
    
        return redirect()->route('course-classes.index')->with('success', 'Course Class updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CourseClass  $courseClass
     * @return \Illuminate\Http\Response
     */
    public function destroy(CourseClass $courseClass)
    {
        $courseClass->delete();

        return redirect()->route('course-classes.index')
            ->with('success', 'Course Class deleted successfully');
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
    
}
