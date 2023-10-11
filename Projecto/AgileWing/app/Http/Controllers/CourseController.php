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

        $ufcds = Ufcd::all();
        $specializationAreas = SpecializationArea::all();

        return view('pages.courses.crud', compact('courses', 'ufcds', 'specializationAreas'));
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
                'name' => 'required|string|max:255|regex:/^[\pL\sÇç]+$/u',
                'initials' => 'required|string|max:255|regex:/^[A-ZÇ]+$/u',
                'specialization_area_number' => 'required|integer|exists:specialization_areas,number',
                'ufcds' => 'required|array',
                'ufcds.*' => 'exists:ufcds,id',
            ],
            [
                'name.required' => 'The name field is required.',
                'name.regex' => 'The name may only contain letters, accentuation, and Ç or ç.',
                'initials.required' => 'The initials field is required.',
                'initials.regex' => 'The initials may only contain uppercase letters and Ç.',
                'specialization_area_number.required' => 'The specialization area number field is required.',
                'specialization_area_number.exists' => 'The provided specialization area number does not exist.',
                'ufcds.required' => 'You must select at least one UFCD.',
                'ufcds.*.exists' => 'One or more selected UFCDs do not exist.',
            ]
        );        

        try {        
            $course = Course::create([
                'name' => $request->name,
                'initials' => $request->initials,
                'specialization_area_number' => $request->specialization_area_number,
            ]);
        
            $course->ufcds()->attach($request->ufcds);
    
            return redirect()->route('courses.index')->with('success', 'Course created successfully');

        } catch (\Exception $e) {
            //In this way you return the error message in the event an error occours after validation with the old form data
            session()->flash('error', 'There was an error creating the course: ' . $e->getMessage());
            return back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255|regex:/^[\pL\sÇç]+$/u',
                'initials' => 'required|string|max:255|regex:/^[A-ZÇ]+$/u',
                'specialization_area_number' => 'required|integer|exists:specialization_areas,number',
                'ufcds' => 'required|array',
                'ufcds.*' => 'exists:ufcds,id',
            ],
            [
                'name.required' => 'The name field is required.',
                'name.regex' => 'The name may only contain letters, accentuation, and Ç or ç.',
                'initials.required' => 'The initials field is required.',
                'initials.regex' => 'The initials may only contain uppercase letters and Ç.',
                'specialization_area_number.required' => 'The specialization area number field is required.',
                'specialization_area_number.exists' => 'The provided specialization area number does not exist.',
                'ufcds.required' => 'You must select at least one UFCD.',
                'ufcds.*.exists' => 'One or more selected UFCDs do not exist.',
            ]
        );        

        try {
            $course = Course::find($id);
        
            $course->update([
                'name' => $request->name,
                'initials' => $request->initials,
                'specialization_area_number' => $request->specialization_area_number,
            ]);
    
            $course->ufcds()->sync($request->ufcds);
        
            return redirect()->route('courses.index')->with('success', 'Course deleted successfully');
        } catch (\Exception $e) {
            //In this way you return the error message in the event an error occours after validation with the old form data
            session()->flash('error', 'There was an error updating the course: ' . $e->getMessage());
            return back()->withInput();
        }
    }    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        try {
            // Soft delete the entries in the pivot table
            \DB::table('course_ufcds')
                ->where('course_id', $course->id)
                ->update(['deleted_at' => now()]);
    
            // Soft delete the course
            $course->delete();
    
            return redirect()->route('courses.index')->with('success', 'Course deleted successfully');
        } catch (\Exception $e) {            
    
            return redirect()->route('courses.index')->with('error', 'There was an error deleting the course.' . $e->getMessage());
        }
    }
}
