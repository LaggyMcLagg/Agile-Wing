<?php

namespace App\Http\Controllers;

use App\TeacherAvailability;
use Illuminate\Http\Request;
use App\User;
use App\HourBlock;
use App\AvailabilityType;

class TeacherAvailabilityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Fetch all teacher availabilities along with the related information
        $teacherAvailabilities = TeacherAvailability::with('user', 'hourBlock', 'availabilityType')->get();

        // Pass the data to the view
        return view('pages.teacher_availabilities.index', compact('teacherAvailabilities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        $hourBlocks = HourBlock::all();
        $availabilityTypes = AvailabilityType::all();
        
        return view('pages.teacher_availabilities.create', compact(
            'users',
            'hourBlocks',
            'availabilityTypes'
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
    
        return redirect()->route('teacher-availabilities.index')->with('success', 'Teacher availability created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TeacherAvailability  $teacherAvailability
     * @return \Illuminate\Http\Response
     */
    public function show(TeacherAvailability $teacherAvailability)
    {
        // Eager load the necessary relationships
        $teacherAvailability->load('user', 'hourBlock', 'availabilityType');
        
        // Pass the data to the view
        return view('pages.teacher_availabilities.show', compact('teacherAvailability'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TeacherAvailability  $teacherAvailability
     * @return \Illuminate\Http\Response
     */
    public function edit(TeacherAvailability $teacherAvailability)
    {
        $users = User::all();
        $hourBlocks = HourBlock::all();
        $availabilityTypes = AvailabilityType::all();
        
        return view('pages.teacher_availabilities.edit', compact('teacherAvailability', 'users', 'hourBlocks', 'availabilityTypes'));
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
    
        return redirect()->route('teacher-availabilities.index')->with('success', 'Teacher availability updated successfully');
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
    
        return redirect()->route('teacher-availabilities.index')
                         ->with('success', 'Teacher availability deleted successfully');
    }
    
}
