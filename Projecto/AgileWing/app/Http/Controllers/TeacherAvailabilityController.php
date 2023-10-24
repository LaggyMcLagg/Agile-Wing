<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TeacherAvailability;
use App\User;
use App\HourBlock;
use App\AvailabilityType;
use Illuminate\Support\Facades\Auth; //to get the logged in user
use Illuminate\Support\Facades\Validator; // to use costum rules in the validator
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
        $rules = [
            'user_id' => 'required|exists:users,id',
            'start_date' => 'required|date|after:today',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'start_hour_block_id' => 'required|exists:hour_blocks,id',
            'end_hour_block_id' => 'nullable|exists:hour_blocks,id',
            'availability_type_id' => 'required|exists:availability_types,id',
        ];
        
        //so that if the is not the same then the GTE - greater or equal does not apply
        //this adds the rule if the dates are the same
        if ($request->input('start_date') === $request->input('end_date')) {
            $rules['end_hour_block_id'][] = 'gte:start_hour_block_id';
        }
        
        $messages = [
            'user_id.required' => 'O campo user_id é obrigatório.',
            'user_id.exists' => 'O utilizador selecionado não é válido.',
            'start_date.required' => 'A data de início é obrigatória.',
            'start_date.date' => 'A data de início deve ser uma data válida.',
            'start_date.after' => 'A data de início deve ser após a data de hoje.',
            'end_date.date' => 'A data de fim deve ser uma data válida.',
            'end_date.after_or_equal' => 'A data de fim deve ser igual ou posterior à data de início.',
            'start_hour_block_id.required' => 'O campo start_hour_block_id é obrigatório.',
            'start_hour_block_id.exists' => 'O bloco de hora de início selecionado não é válido.',
            'end_hour_block_id.exists' => 'O bloco de hora de fim selecionado não é válido.',
            'end_hour_block_id.gte' => 'O bloco de hora de fim deve ser igual ou posterior ao bloco de hora de início.',
            'availability_type_id.required' => 'O tipo de disponibilidade é obrigatório.',
            'availability_type_id.exists' => 'O tipo de disponibilidade selecionado não é válido.'
        ];

        $request->validate($rules, $messages);

        try {
            $startDate = Carbon::parse($request->start_date);
    
            // If only start date is provided, handle single date entry.
            if (!$request->has('end_date')) {
                $this->updateOrCreateSingleEntry($request, $startDate);
            } else {
                $endDate = Carbon::parse($request->end_date);
                $this->updateOrCreateDateRange($request, $startDate, $endDate);
            }
        } catch (\Exception $e) {
            \Log::error('Error while storing teacher availability: ' . $e->getMessage());
            return redirect()->back()->withInput()->withErrors(['error' => 'Ocorreu um erro ao processar este pedido. Por favor tente mais tarde.']);
        }
    
        return redirect()->route('teacher-availabilities.create')->with('success', 'Disponibilidades criadas ou atualizadas com sucesso.');
    }
    
    /**
     * Auxiliary method to create () Handle the single date entry.
     */
    private function updateOrCreateSingleEntry($request, $date)
    {
        dd("single");
        $hourBlock = HourBlock::findOrFail($request->start_hour_block_id);
    
        TeacherAvailability::updateOrCreate(
            [
                'user_id' => $request->user_id,
                'availability_date' => $date->toDateString(),
                'hour_block_id' => $hourBlock->id,
            ],
            [
                'availability_type_id' => $request->availability_type_id,
            ]
        );
    }
    
    /**
     * Auxiliary method to create () Handle the date range entries.
     */
    private function updateOrCreateDateRange($request, $startDate, $endDate)
    {
        dd("range");
        $startHourBlock = HourBlock::findOrFail($request->start_hour_block_id);
        $endHourBlock = HourBlock::findOrFail($request->end_hour_block_id);
    
        // Process each date in the range. LTE - less then or equal to
        for($date = $startDate; $date->lte($endDate); $date->addDay()) {
            // Process each hour block in the range.
            $hourBlocks = HourBlock::whereBetween('id', [$startHourBlock->id, $endHourBlock->id])->get();
            foreach($hourBlocks as $hourBlock) {
                TeacherAvailability::updateOrCreate(
                    [
                        'user_id' => $request->user_id,
                        'availability_date' => $date->toDateString(),
                        'hour_block_id' => $hourBlock->id,
                    ],
                    [
                        'availability_type_id' => $request->availability_type_id,
                    ]
                );
            }
        }
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
