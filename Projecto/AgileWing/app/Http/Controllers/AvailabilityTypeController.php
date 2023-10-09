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
        $availabilityTypes = AvailabilityType::all();
        $defaultAvailabilityType = $availabilityTypes->first();

        return view('pages.availability_types.crud', compact ('availabilityTypes', 'defaultAvailabilityType'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
            'color' => 'required|string|max:7',
        ]);

        AvailabilityType::create($request->all());

        return redirect()->route('availability-types.index')->with('success', 'Registo criado com sucesso!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\AvailabilityType  $availabilityType
     * @return \Illuminate\Http\Response
     */
    public function show(AvailabilityType $availabilityType)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AvailabilityType  $availabilityType
     * @return \Illuminate\Http\Response
     */
    public function edit(AvailabilityType $availabilityType)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AvailabilityType  $availabilityType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $availabilityType = AvailabilityType::find($id);
        $availabilityType->name = $request->name;
        $availabilityType->color = $request->color;
        $availabilityType->save();

        return redirect()->route('availability-types.index')->with('success', 'Registo editado com sucesso!');
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
        return redirect()->route('availability-types.index')->with('success', 'Registo apagado com sucesso');
    }
}
