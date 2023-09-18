<?php

namespace App\Http\Controllers;

use App\CourseUfcd;
use App\Course;
use App\Ufcd;
use Illuminate\Http\Request;

class CourseUfcdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courseUfcds = CourseUfcd::with('ufcd', 'course')->get();

        return view('pages.course_ufcd.index', compact('courseUfcds'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ufcds = Ufcd::all();
        $courses = Course::all();

            return view('pages.course_ufcd.create', compact('ufcds', 'courses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validar dados
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'ufcd_id' => 'required|exists:ufcds,id',
        ]);


        CourseUfcd::create($request->all());

        return redirect()->route('course-ufcd.index')->with('status', 'Course Ufcd created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CourseUfcd  $courseUfcd
     * @return \Illuminate\Http\Response
     */
    public function show(CourseUfcd $courseUfcd)
    {
         // Eager load the necessary relationships
         $courseUfcd->load('ufcd', 'course',);

         // Pass the data to the view
         return view('pages.course_ufcd.show', compact('courseUfcd'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CourseUfcd  $courseUfcd
     * @return \Illuminate\Http\Response
     */
    public function edit(CourseUfcd $courseUfcd)
    {
        $courses = Course::all();
        $ufcds = Ufcd::all();

        return view('pages.course_ufcd.edit', compact('courseUfcd', 'courses', 'ufcds'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CourseUfcd  $courseUfcd
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CourseUfcd $courseUfcd)
    {
        $request->validate([

            'course_id' => 'required|exists:course_id',
            'ufcd_id' => 'required|exists:ufcds,id',

        ]);

        $courseUfcd->update($request->all());

        return redirect()->route('course-ufcd.index')->with('status', 'Course UFCD updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CourseUfcd  $courseUfcd
     * @return \Illuminate\Http\Response
     */
    public function destroy(CourseUfcd $courseUfcd)
    {
        $courseUfcd->delete();

        return redirect()->route('course-ufcd.index', $courseUfcd);
    }
}
