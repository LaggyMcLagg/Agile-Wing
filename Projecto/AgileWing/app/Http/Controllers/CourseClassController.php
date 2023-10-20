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
            'number.required' => 'O campo numérico é obrigatório.',
            'number.regex' => 'O número deve estar no formato XX.XX (por exemplo, 12.34).',
            'number.unique' => 'O número fornecido já existe.',
            'name.required' => 'O campo nome é obrigatório.',
            'name.regex' => 'O nome só pode conter letras, acentuação e Ç ou ç.',
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
            'number.required' => 'O campo numérico é obrigatório.',
            'number.regex' => 'O número deve estar no formato XX.XX (por exemplo, 12.34).',
            'number.unique' => 'O número fornecido já existe.',
            'name.required' => 'O campo nome é obrigatório.',
            'name.regex' => 'O nome só pode conter letras, acentuação e Ç ou ç.',
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
