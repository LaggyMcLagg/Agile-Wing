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
                'hour_beginning.required' => 'O campo de início da hora é obrigatório.',
                'hour_beginning.date_format' =>  'O início da hora deve estar no formato hh:mm:ss.',
                'hour_beginning.before' => 'O início da hora deve ser antes do final da hora.',
                'hour_end.required' => 'O campo de final de hora é obrigatório.',
                'hour_end.date_format' => 'O final da hora deve estar no formato hh:mm:ss.',
                'hour_end.after' => 'O final da hora deve ser posterior ao início da hora.',
            ]
        ); 
    
        // Se a validação passar, crie o registro
        HourBlock::create($request->all());
    
        return redirect()->route('hour-blocks.index')->with('success', 'Bloco de horário criado com sucesso.');
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
                'hour_beginning.required' => 'O campo de início da hora é obrigatório.',
                'hour_beginning.date_format' => 'O início da hora deve estar no formato hh:mm:ss.',
                'hour_beginning.before' => 'O início da hora deve ser antes do final da hora.',
                'hour_end.required' => 'O campo de final de hora é obrigatório.',
                'hour_end.date_format' => 'O final da hora deve estar no formato hh:mm:ss.',
                'hour_end.after' => 'O final da hora deve ser posterior ao início da hora.',
            ]
        ); 
 
    $hourBlock->update($request->all());

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
        return redirect()->route('hour-blocks.index')->with('success', 'Blogo de horário apagado com sucesso');
    }
}
