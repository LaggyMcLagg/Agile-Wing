<?php

namespace App\Http\Controllers;

use App\SpecializationArea;
use App\Course;
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
        $specializationAreas = SpecializationArea::with('courses', 'users')->get();

        return view('pages.specialization_areas.crud', compact('specializationAreas'));
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
            'number' => 'required|integer|unique:specialization_areas,number',
            'name' => 'required|string|max:255|regex:/^[\pL\sÇç]+$/u',
        ], [
            'number.required' => 'The number field is required.',
            'number.unique' => 'The provided number already exists.',
            'name.required' => 'The name field is required.',
            'name.regex' => 'The name may only contain letters, accentuation, and Ç or ç.',
        ]);

        try {
            SpecializationArea::create([
                'number' => $request->number,
                'name' => $request->name,
            ]);

            return redirect()->route('specialization-areas.index')->with('success', 'Specialization Area created successfully');

        } catch (\Exception $e) {
            session()->flash('error', 'There was an error creating the specialization area: ' . $e->getMessage());
            return back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SpecializationArea  $specializationArea
     * @return \Illuminate\Http\Response
     */
    public function show(SpecializationArea $specializationArea)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SpecializationArea  $specializationArea
     * @return \Illuminate\Http\Response
     */
    public function edit(SpecializationArea $specializationArea)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $specializationArea = SpecializationArea::find($id);
        
        $request->validate([
            'number' => 'required|integer|unique:specialization_areas,number,' . $specializationArea->id,
            'name' => 'required|string|max:255|regex:/^[\pL\sÇç]+$/u',
        ], [
            'number.required' => 'The number field is required.',
            'number.unique' => 'The provided number already exists for another specialization area.',
            'name.required' => 'The name field is required.',
            'name.regex' => 'The name may only contain letters, accentuation, and Ç or ç.',
        ]);

        try {

            $specializationArea->update([
                'number' => $request->number,
                'name' => $request->name,
            ]);

            return redirect()->route('specialization-areas.index')->with('success', 'Specialization Area updated successfully');

        } catch (\Exception $e) {
            session()->flash('error', 'There was an error updating the specialization area: ' . $e->getMessage());
            return back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SpecializationArea  $specializationArea
     * @return \Illuminate\Http\Response
     */
    public function destroy(SpecializationArea $specializationArea)
    {
        try {
            // Soft delete the specialization area
            $specializationArea->delete();

            return redirect()->route('specialization-areas.index')->with('success', 'Specialization Area deleted successfully');

        } catch (\Exception $e) {
            return redirect()->route('specialization-areas.index')->with('error', 'There was an error deleting the specialization area. ' . $e->getMessage());
        }
    }
}
