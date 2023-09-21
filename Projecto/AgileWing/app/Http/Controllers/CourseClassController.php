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
        $courseClasses = CourseClass::orderBy('id', 'desc')->get();
        return view('pages.course-classes.index', ['courseClasses' => $courseClasses]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $courses = Course::all();
        return view('pages.course-classes.create', compact('courses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'number' => 'required',
            'course_id' => 'required',
        ]);

        CourseClass::create($request->all());

        return redirect()->route('course-classes.index')->with('status', 'Item created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CourseClass  $courseClass
     * @return \Illuminate\Http\Response
     */
    public function show(CourseClass $courseClass)
    {

        $courseClass->load('course');
        return view('pages.course-classes.show', compact('courseClass'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CourseClass  $courseClass
     * @return \Illuminate\Http\Response
     */
    public function edit(CourseClass $courseClass)
    {
        $courses = Course::all();
        
        return view('pages.course-classes.edit', compact('courseClass', 'courses'));
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
        $request->validate([
            'course_id' => 'required|exists:courses,id',
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
