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
        $pedagogicalGroups = PedagogicalGroup::with('users', 'ufcds')->get();

        // Pass the data to the view
        return view('pages.pedagogical_groups.crud', compact('pedagogicalGroups'));
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
        $this->validate($request, [
            'name' => 'required'
            ]);

        PedagogicalGroup::create($request->all());
        return redirect()->route('pedagogical-groups.index')->with('success', 'Grupo pedagógico criado com sucesso.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PedagogicalGroup  $pedagogicalGroup
     * @return \Illuminate\Http\Response
     */
    public function show(PedagogicalGroup $pedagogicalGroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PedagogicalGroup  $pedagogicalGroup
     * @return \Illuminate\Http\Response
     */
    public function edit(PedagogicalGroup $pedagogicalGroup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PedagogicalGroup  $pedagogicalGroup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $pedagogicalGroup = PedagogicalGroup::find($id);

        $pedagogicalGroup->update($request->all());
        return redirect('pedagogical-groups')->with('success','Grupo pedagógico editado com sucesso.');
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
        return redirect('pedagogical-groups')->with('success','Grupo pedagógico eliminado com sucesso.');;
    }
}
