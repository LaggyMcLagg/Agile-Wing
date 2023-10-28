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
        $ufcds = Ufcd::with('pedagogicalGroup', 'courses', 'users')->get();
        $pedagogicalGroups = PedagogicalGroup::all();

        // Pass the data to the view
        return view('pages.ufcds.crud', compact('ufcds', 'pedagogicalGroups'));
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
        $data = $request->validate([
            'number' => 'required|numeric',
            'name' => 'required',
            'hours' => 'required|numeric',
            'pedagogical_group_id' => 'required'
        ],
        [
            'number.required' => 'O campo numérico é obrigatório.',
            'number.regex' => 'O número deve estar no formato XX.XX (por exemplo, 12.34).',
            'number.unique' => 'O número fornecido já existe.',
            'name.required' => 'O campo nome é obrigatório.',
            'name.regex' => 'O nome só pode conter letras, acentuação e Ç ou ç.',
        ]);

        Ufcd::create($data);
    
        return redirect()->route('ufcds.index')->with('success', 'UFCD criada com sucesso.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Ufcd  $ufcd
     * @return \Illuminate\Http\Response
     */
    public function show(Ufcd $ufcd)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ufcd  $ufcd
     * @return \Illuminate\Http\Response
     */
    public function edit(Ufcd $ufcd)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ufcd  $ufcd
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'number' => 'required',
            'name' => 'required',
            'hours' => 'required',
            'pedagogical_group_id' => 'required'
        ]);

        $ufcd = Ufcd::find($id);

        $ufcd->update($request->all());
    
        return redirect()->route('ufcds.index')->with('success', 'UFCD editada com sucesso.');
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
    
        return redirect()->route('ufcds.index')->with('success', 'UFCD apagada com sucesso.');
    }
}
