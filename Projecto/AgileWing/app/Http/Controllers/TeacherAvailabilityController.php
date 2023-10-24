<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TeacherAvailability;
use App\User;
use App\HourBlock;
use App\AvailabilityType;
use Illuminate\Support\Facades\Auth; //to get the logged in user
use Carbon\Carbon;

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
        //vars for content
        $user = Auth::user();
        $userNotes = $user->notes;
        $availabilityTypes = AvailabilityType::all();
        $hourBlocks = HourBlock::orderBy('hour_beginning', 'asc')->get();
        $teacherAvailabilities = TeacherAvailability::where('user_id', $user->id)->get();
        
        //var for component setup
        $showNotes = true;
        $showLegend = true;
        $showBtnStore = true;
        $objectName = $user->name;
        $jsonTeacherAvailabilities = json_encode($teacherAvailabilities);

        return view('pages.teacher_availabilities.index', 
        compact(
            'userNotes',
            'availabilityTypes',
            'hourBlocks',
            'teacherAvailabilities',

            'showNotes',
            'showLegend',
            'showBtnStore',
            'objectName',
            'jsonTeacherAvailabilities'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $userId = Auth::user()->id;
        $teacherAvailabilities = TeacherAvailability::with('hourBlock', 'availabilityType')
        ->where('user_id', $userId)
        ->where('is_locked', '!=', 1)
        ->get();
        
        //group by expects a string not date so we need to cast
        $teacherAvailabilitiesGroupedByDate = $teacherAvailabilities->groupBy(function($date) {
            return Carbon::parse($date->availability_date)->format('Y-m-d'); // using a fixed format
        });
        
        $hourBlocks = HourBlock::all();
        $availabilityTypes = AvailabilityType::all();

        $isEditing = false;

        return view('pages.teacher_availabilities.crud', compact('teacherAvailabilitiesGroupedByDate', 'hourBlocks', 'availabilityTypes', 'isEditing', 'userId'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'availability_date' => 'required|date|after:today',
            'hour_block_id' => 'required|exists:hour_blocks,id',
            'availability_type_id' => 'required|exists:availability_types,id',
        ]);
    
        TeacherAvailability::create($request->all());
    
        return redirect()->route('teacher-availabilities.create')->with('success', 'Disponibilidade criada com sucesso.');
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
    public function edit($id)
    {
        //TeacherAvailability $teacherAvailability
        return view('pages.teacher_availabilities.edit', compact()); 
    }
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TeacherAvailability  $teacherAvailability
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $teacherAvailability = TeacherAvailability::find($id);
        // dd($teacherAvailability, $id, $request);
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'availability_date' => 'required|date|after:today',
            'hour_block_id' => 'required|exists:hour_blocks,id',
            'availability_type_id' => 'required|exists:availability_types,id',
        ]);
    
        $teacherAvailability->update($request->all());
    
        return redirect()->route('teacher-availabilities.create')->with('success', 'Disponibilidade actualizada com sucesso.');
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TeacherAvailability  $teacherAvailability
     * @return \Illuminate\Http\Response
     */
    public function destroy(TeacherAvailability $teacherAvailability)
    {
        //
    }

    //###############################
    //OTHER METHODS
    //###############################

    public function deleteSelected(Request $request)
    {
        try {
            TeacherAvailability::whereIn('id', $request->input('ids'))->delete();
            return redirect()->back()->with('success', 'Registos apagados.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao apagar os registos.');
        }
    }
        
    public function publishSelected(Request $request)
    {
        try {
            TeacherAvailability::whereIn('id', $request->input('ids'))->update(['is_locked' => true]);
            return redirect()->back()->with('success', 'Resgistos publicados.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao publicar os registos.');
        }
    }    
    
}
