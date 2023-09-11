<?php

namespace App\Http\Controllers;

use App\AvailabilityType;
use Illuminate\Http\Request;

class AvailabilityTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $availabilityTipes = AvailabilityType::all();
        return view('pages.availability-types.index', ['availabilityTypes' => $availabilityTipes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.availability-types.create');

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
        ]);

        AvailabilityType::create($request->all());

        return redirect('availability_types')->with('status', 'Registo criado com sucesso!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\AvailabilityType  $availabilityType
     * @return \Illuminate\Http\Response
     */
    public function show(AvailabilityType $availabilityType)
    {
        return view('pages.availability-types.show', ['availabilityType' => $availabilityType]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AvailabilityType  $availabilityType
     * @return \Illuminate\Http\Response
     */
    public function edit(AvailabilityType $availabilityType)
    {
        return view('pages.availability-types.edit', ['availabilityType' => $availabilityType]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AvailabilityType  $availabilityType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AvailabilityType $availabilityType)
    {
        $availabilityType = AvailabilityType::find($availabilityType->id);
        $availabilityType->name = $request->name;
        $availabilityType->save();

        return redirect('availability_types')->with('status', 'Registo editado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AvailabilityType  $availabilityType
     * @return \Illuminate\Http\Response
     */
    public function destroy(AvailabilityType $availabilityType)
    {
        $availabilityType->delete();
        return redirect('availability_types')->with('status', 'Registo apagado com sucesso');
    }
}
