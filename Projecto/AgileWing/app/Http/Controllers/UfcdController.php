<?php

namespace App\Http\Controllers;

use App\PedagogicalGroup;
use App\Ufcd;
use Illuminate\Http\Request;

class UfcdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Fetch all teacher availabilities along with the related information
        $ufcds = Ufcd::with('pedagogicalGroup')->get();

        // Pass the data to the view
        return view('pages.ufcds.index', compact('ufcds'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pedagogicalGroups = PedagogicalGroup::all();

        return view('pages.ufcds.create', compact(
            'pedagogicalGroups'

        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'pedagogical_group_id' => 'required',
            'number' => 'required',
            'hours' => 'required'
        ]);
    
        Ufcd::create($data);
    
        return redirect()->route('ufcds.index')->with('success', 'UFCD created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Ufcd  $ufcd
     * @return \Illuminate\Http\Response
     */
    public function show(Ufcd $ufcd)
    {
        // Eager load the necessary relationships
        $ufcd->load('pedagogicalGroup');

        // Pass the data to the view
        return view('pages.ufcds.show', compact('ufcd'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ufcd  $ufcd
     * @return \Illuminate\Http\Response
     */
    public function edit(Ufcd $ufcd)
    {
        $pedagogicalGroups = PedagogicalGroup::all();
        
        return view('pages.ufcds.edit', compact('ufcd', 'pedagogicalGroups'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ufcd  $ufcd
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ufcd $ufcd)
    {
        
        $this->validate($request, [
            'name' => 'required',
            'pedagogical_group_id' => 'required',
            'number' => 'required',
            'hours' => 'required'
        ]);
    
        $ufcd->update($request->all());
    
        return redirect()->route('ufcds.index')->with('success', 'UFCD updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ufcd  $ufcd
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ufcd $ufcd)
    {
        $ufcd->delete();
    
        return redirect()->route('ufcds.index')
                         ->with('success', 'Ufcd deleted successfully');
    }
}
