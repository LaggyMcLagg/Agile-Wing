<?php

namespace App\Http\Controllers;

use App\SpecializationArea;
use Illuminate\Http\Request;

class SpecializationAreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $specializationAreas = SpecializationArea::orderBy('name')->get();

        // Pass the data to the view
        return view('pages.specialization-areas.index', ['specializationAreas' => $specializationAreas]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.specialization-areas.create');
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
            'number' => 'required',
            'name' => 'required'
            ]);

            SpecializationArea::create($request->all());
            return redirect()->route('specialization-areas.index')->with('success', 'Specialization Area created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SpecializationArea  $specializationArea
     * @return \Illuminate\Http\Response
     */
    public function show(SpecializationArea $specializationArea)
    {
        return view('pages.specialization-areas.show', ['specializationArea' => $specializationArea]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SpecializationArea  $specializationArea
     * @return \Illuminate\Http\Response
     */
    public function edit(SpecializationArea $specializationArea)
    {
        return view('pages.specialization-areas.edit', ['specializationArea' => $specializationArea]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SpecializationArea  $specializationArea
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SpecializationArea $specializationArea)
    {

        $specializationArea->number = $request->number;
        $specializationArea->name = $request->name;
        $specializationArea->save();
        
        return redirect('specialization-areas')->with('status','Item edited successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SpecializationArea  $specializationArea
     * @return \Illuminate\Http\Response
     */
    public function destroy(SpecializationArea $specializationArea)
    {
        $specializationArea->delete();
        return redirect('specialization-areas')->with('status','Item deleted successfully!');
    }
}
