<?php

namespace App\Http\Controllers;

use App\PedagogicalGroup;
use Illuminate\Http\Request;

class PedagogicalGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pedagogicalGroups = PedagogicalGroup::orderBy('id', 'desc')->get();

        // Pass the data to the view
        return view('pages.pedagogical-groups.index', ['pedagogicalGroups' => $pedagogicalGroups]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.pedagogical-groups.create');

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

            PedagogicalGroup::create($request->all());
            return redirect()->route('pedagogical-groups.index')->with('success', 'Pedagogical Groups created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PedagogicalGroup  $pedagogicalGroup
     * @return \Illuminate\Http\Response
     */
    public function show(PedagogicalGroup $pedagogicalGroup)
    {
        return view('pages.pedagogical-groups.show', ['pedagogicalGroup' => $pedagogicalGroup]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PedagogicalGroup  $pedagogicalGroup
     * @return \Illuminate\Http\Response
     */
    public function edit(PedagogicalGroup $pedagogicalGroup)
    {
        return view('pages.pedagogical-groups.edit', ['pedagogicalGroup' => $pedagogicalGroup]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PedagogicalGroup  $pedagogicalGroup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PedagogicalGroup $pedagogicalGroup)
    {
        $pedagogicalGroup->update($request->all());
        return redirect('pedagogical-groups')->with('status','Item edited successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PedagogicalGroup  $pedagogicalGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(PedagogicalGroup $pedagogicalGroup)
    {
        $pedagogicalGroup->delete();
        return redirect('pedagogical-groups')->with('status','Item deleted successfully!');
    }
}
