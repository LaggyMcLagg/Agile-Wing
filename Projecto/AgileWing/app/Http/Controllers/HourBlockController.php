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
    public function index(HourBlock $hourBlock)
    {
        $hourBlocks = HourBlock::all();
        return view('pages.hour-blocks.index', [
            'hourBlock'  =>$hourBlock,
            'hourBlocks' => $hourBlocks]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.hour-blocks.create');
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

        return redirect('hour-blocks')->with('status', 'Registo criado com sucesso!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\HourBlock  $hourBlock
     * @return \Illuminate\Http\Response
     */
    public function show(HourBlock $hourBlock)
    {
        return view('pages.hour-blocks.show', [
            'hourBlock' => $hourBlock]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\HourBlock  $hourBlock
     * @return \Illuminate\Http\Response
     */
    public function edit(HourBlock $hourBlock)
    {
        return view('pages.hour-blocks.edit', ['hourBlock' => $hourBlock]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\HourBlock  $hourBlock
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HourBlock $hourBlock)
    {
        $hourBlock = HourBlock::find($hourBlock->id);
        $hourBlock->hour_beginning = $request->hour_beginning;
        $hourBlock->hour_end = $request->hour_end;
        $hourBlock->save();

        return redirect('hour-blocks')->with('status', 'Registo editado com sucesso!');
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
        return redirect('hour-blocks')->with('status', 'Registo apagado com sucesso');
    }
}
