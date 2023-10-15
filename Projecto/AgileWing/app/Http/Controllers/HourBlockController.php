<?php

namespace App\Http\Controllers;

use App\HourBlock;
use Illuminate\Http\Request;

class HourBlockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hourBlocks = HourBlock::all();
        //default é para a action do update ter um valor para o ID do hourBlock por default senao nao consigo entrar na pagina sequer
        $defaultHourBlock = $hourBlocks->first();
        return view('pages.hour_blocks.crud', compact ('hourBlocks', 'defaultHourBlock'));
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
                'hour_beginning' => 'required|date_format:H:i:s|before:hour_end',
                'hour_end' => 'required|date_format:H:i:s|after:hour_beginning',
            ],
            [
                'hour_beginning.required' => 'The hour beginning field is required.',
                'hour_beginning.date_format' => 'The hour beginning must be in the format hh:mm:ss.',
                'hour_beginning.before' => 'The hour beginning must be before the hour end.',
                'hour_end.required' => 'The hour end field is required.',
                'hour_end.date_format' => 'The hour end must be in the format hh:mm:ss.',
                'hour_end.after' => 'The hour end must be after the hour beginning.',
            ]
        ); 
    
        // Se a validação passar, crie o registro
        HourBlock::create($request->all());
    
        return redirect()->route('hour-blocks.index')->with('success', 'Registo criado com sucesso!');
    }
    

    /**
     * Display the specified resource.
     *
     * @param  \App\HourBlock  $hourBlock
     * @return \Illuminate\Http\Response
     */
    public function show(HourBlock $hourBlock)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\HourBlock  $hourBlock
     * @return \Illuminate\Http\Response
     */
    public function edit(HourBlock $hourBlock)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\HourBlock  $hourBlock
     * @return \Illuminate\Http\Response
     */
public function update(Request $request, $id)
{
    // Encontre o HourBlock existente pelo ID
    $hourBlock = HourBlock::find($id);

    $request->validate(
        [
            'hour_beginning' => 'required|date_format:H:i:s|before:hour_end',
            'hour_end' => 'required|date_format:H:i:s|after:hour_beginning',
        ],
        [
            'hour_beginning.required' => 'The hour beginning field is required.',
            'hour_beginning.date_format' => 'The hour beginning must be in the format hh:mm:ss.',
            'hour_beginning.before' => 'The hour beginning must be before the hour end.',
            'hour_end.required' => 'The hour end field is required.',
            'hour_end.date_format' => 'The hour end must be in the format hh:mm:ss.',
            'hour_end.after' => 'The hour end must be after the hour beginning.',
        ]
    ); 

    // Se a validação passar, atualize o registro existente
    $hourBlock->hour_beginning = $hourBeginning;
    $hourBlock->hour_end = $hourEnd;
    $hourBlock->save();

    return redirect()->route('hour-blocks.index')->with('success', 'Registo editado com sucesso!');
}


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\HourBlock  $hourBlock
     * @return \Illuminate\Http\Response
     */
    public function destroy(HourBlock $hourBlock)
    {
        $hourBlock->delete();
        return redirect()->route('hour-blocks.index')->with('success', 'Registo apagado com sucesso');
    }
}
