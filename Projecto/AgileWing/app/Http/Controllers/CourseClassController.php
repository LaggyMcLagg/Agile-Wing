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
        return view('pages.course-classes.create');
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

            return redirect('course-classes')->with('status','Item created successfully!');
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
        //
    }
}
