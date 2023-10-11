<?php

namespace App\Http\Controllers;

use App\HourBlock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; //usado na verificacao do create e update 

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
        // Validação personalizada para verificar se hour_beginning é menor que hour_end
        $validator = Validator::make($request->all(), [
            'hour_beginning' => 'required',
            'hour_end' => 'required',
        ]);
    
        $hourBeginning = $request->input('hour_beginning');
        $hourEnd = $request->input('hour_end');
    
        // Verifique se hour_beginning é menor que hour_end
        if ($hourBeginning >= $hourEnd) 
        {
            $validator->after(function ($validator) {
                $validator->errors()->add('hour_beginning', 'A hora de início deve ser menor que a hora de fim.');
            });
        }
    
        // Verifique se a validação falhou
        if ($validator->fails()) 
        {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();//faz refresh à página com mensagem de erro e os antigos inputs já inseridos
        }
    
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

    // Validação personalizada para verificar se hour_beginning é menor que hour_end
    $validator = Validator::make($request->all(), [
        'hour_beginning' => 'required',
        'hour_end' => 'required',
    ]);

    $hourBeginning = $request->input('hour_beginning');
    $hourEnd = $request->input('hour_end');

    // Verifique se hour_beginning é menor que hour_end
    if ($hourBeginning >= $hourEnd) {
        $validator->after(function ($validator) {
            $validator->errors()->add('hour_beginning', 'A hora de início deve ser menor que a hora de fim.');
        });
    }

    // Verifique se a validação falhou
    if ($validator->fails()) {
        return redirect()
            ->back()
            ->withErrors($validator)
            ->withInput();
    }

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
