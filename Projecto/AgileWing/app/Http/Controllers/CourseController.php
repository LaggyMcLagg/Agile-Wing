<?php

namespace App\Http\Controllers;

use App\Course;
use App\Ufcd;
use App\SpecializationArea;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses = Course::with('specializationArea', 'courseClasses', 'ufcds')->get();

        return view('pages.courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ufcds = Ufcd::all();
        $specializationAreas = SpecializationArea::all();

        return view('pages.courses.create', compact('ufcds', 'specializationAreas'));
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
            'name' => 'required|string|max:255',
            'initials' => 'required|string|max:255',
            'specialization_area_number' => 'required|integer|exists:specialization_areas,number',
            'ufcds' => 'required|array',
            'ufcds.*' => 'exists:ufcds,id',
        ]);

        $course = Course::create([
            'name' => $request->name,
            'initials' => $request->initials,
            'specialization_area_number' => $request->specialization_area_number,
        ]);

        $course->ufcds()->attach($request->ufcds);

        return redirect()->route('courses.index')->with('success', 'Course created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        $course->load('ufcds', 'courseClasses', 'specializationArea');

        return view('pages.courses.show', compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        $ufcds = Ufcd::all();
        $specializationAreas = SpecializationArea::all();
        $course->load('ufcds', 'specializationArea');

        return view('pages.courses.edit', compact('course', 'ufcds', 'specializationAreas'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'initials' => 'required|string|max:255',
            'specialization_area_number' => 'required|integer|exists:specialization_areas,number',
            'ufcds' => 'required|array',
            'ufcds.*' => 'exists:ufcds,id',
        ]);

        $course->update([
            'name' => $request->name,
            'initials' => $request->initials,
            'specialization_area_number' => $request->specialization_area_number,
        ]);

        $course->ufcds()->sync($request->ufcds);

        return redirect()->route('courses.index')->with('success', 'Course updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        // Soft delete the entries in the pivot table
        \DB::table('course_ufcds')
            ->where('course_id', $course->id)
            ->update(['deleted_at' => now()]);

        // Soft delete the course
        $course->delete();

        return redirect()->route('courses.index')
            ->with('success', 'Course deleted successfully');
    }
}
