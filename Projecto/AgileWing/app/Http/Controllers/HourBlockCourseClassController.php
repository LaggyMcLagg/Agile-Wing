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
                'course_class_id.required' => 'O campo de Turma é obrigatório.',
                'course_class_id.exists' => 'A Turma seleccionda é inválida.',
                'hour_beginning.required' => 'O campo de início da hora é obrigatório.',
                'hour_beginning.date_format' =>  'O início da hora deve estar no formato hh:mm:ss.',
                'hour_beginning.before' => 'O início da hora deve ser antes do final da hora.',
                'hour_end.required' => 'O campo de final de hora é obrigatório.',
                'hour_end.date_format' => 'O final da hora deve estar no formato hh:mm:ss.',
                'hour_end.after' => 'O final da hora deve ser posterior ao início da hora.',

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
                'course_class_id.required' => 'O campo de Turma é obrigatório.',
                'course_class_id.exists' => 'A Turma seleccionda é inválida.',
                'hour_beginning.required' => 'O campo de início da hora é obrigatório.',
                'hour_beginning.date_format' =>  'O início da hora deve estar no formato hh:mm:ss.',
                'hour_beginning.before' => 'O início da hora deve ser antes do final da hora.',
                'hour_end.required' => 'O campo de final de hora é obrigatório.',
                'hour_end.date_format' => 'O final da hora deve estar no formato hh:mm:ss.',
                'hour_end.after' => 'O final da hora deve ser posterior ao início da hora.',
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
