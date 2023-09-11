<?php

namespace App\Http\Controllers;

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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $hourBlockCourseClasses = HourBlockCourseClass::orderBy('id', 'desc')->get();
        return view('pages.hour-block-course-classes.index', ['hourBlockCourseClasses' => $hourBlockCourseClasses]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function update(Request $request, HourBlockCourseClass $hourBlockCourseClass)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\HourBlockCourseClass  $hourBlockCourseClass
     * @return \Illuminate\Http\Response
     */
    public function destroy(HourBlockCourseClass $hourBlockCourseClass)
    {
        //
    }
}
