<?php

namespace App\Http\Controllers;

use App\CourseClass;
use App\HourBlockCourseClass;
use App\Ufcd;
use App\User;
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
        return view('course-classes.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $validatedData = $request->validate([
        'name' => 'required|max:255',

    ]);


    $courseClass = new CourseClass;
    $courseClass->name = $request->input('name');



    $courseClass->save();

    // Redirecione para a página de detalhes da turma recém-criada
    return redirect()->route('course-class.show', ['courseClass' => $courseClass]);
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
        $courseClass->delete();
        return redirect()->route('course-class.indexForScheduleAtribution')->with('success', 'Horário excluído com sucesso!');
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
        $users = User::all();
        $ufcds = Ufcd::all();
        $hourBlocks = HourBlockCourseClass::where('course_class_id', $courseClass->id)->get();
        return view('pages.course_classes.showForScheduleAtribution', compact ('courseClass', 'scheduleAtributions', 'hourBlocks', 'ufcds', 'users'));
    }

    public function createForScheduleAtribution()
    {
        $courseClasses = CourseClass::with('course.specializationArea')->get();
        return view('pages.course_classes.createForScheduleAtribution', compact ('courseClasses'));
    }
}
