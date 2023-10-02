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
        $this->validate($request, [
            'hour_beginning'    => 'required',
            'hour_end'          => 'required',
        ]);

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
        $hourBlock = HourBlock::find($id);
        $hourBlock->hour_beginning = $request->hour_beginning;
        $hourBlock->hour_end = $request->hour_end;
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
