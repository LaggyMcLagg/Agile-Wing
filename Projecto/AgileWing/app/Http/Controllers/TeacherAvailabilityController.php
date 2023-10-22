<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TeacherAvailability;
use App\User;
use App\HourBlock;
use App\AvailabilityType;
use Illuminate\Support\Facades\Auth; //to get the logged in user

class TeacherAvailabilityController extends Controller
{
    //###############################
    //CRUD METHODS
    //###############################
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //to get the value even if it is false, because if false the form
        //sends it null instead
        $request->merge(['is_locked' => $request->has('is_locked')]);

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'availability_date' => 'required|date|after:today',
            'is_locked' => 'required|boolean',
            'hour_block_id' => 'required|exists:hour_blocks,id',
            'availability_type_id' => 'required|exists:availability_types,id',
        ]);
    
        TeacherAvailability::create($request->all());
    
        return redirect()->route('teacher-availabilities.crud')->with('success', 'Teacher availability created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TeacherAvailability  $teacherAvailability
     * @return \Illuminate\Http\Response
     */
    public function show(TeacherAvailability $teacherAvailability)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TeacherAvailability  $teacherAvailability
     * @return \Illuminate\Http\Response
     */
    public function edit(TeacherAvailability $teacherAvailability)
    {
        //
    }
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TeacherAvailability  $teacherAvailability
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TeacherAvailability $teacherAvailability)
    {
        $request->merge(['is_locked' => $request->has('is_locked')]);
    
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'availability_date' => 'required|date|after:today',
            'is_locked' => 'required|boolean',
            'hour_block_id' => 'required|exists:hour_blocks,id',
            'availability_type_id' => 'required|exists:availability_types,id',
        ]);
    
        $teacherAvailability->update($request->all());
    
        return redirect()->route('teacher-availabilities.crud')->with('success', 'Teacher availability updated successfully');
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TeacherAvailability  $teacherAvailability
     * @return \Illuminate\Http\Response
     */
    public function destroy(TeacherAvailability $teacherAvailability)
    {
        $teacherAvailability->delete();
    
        return redirect()->route('teacher-availabilities.crud')->with('success', 'Teacher availability deleted successfully');
    }

    //###############################
    //OTHER METHODS
    //###############################
    
    public function Crud()
    {
        //
    }
}
