<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TeacherAvailability;
use App\User;
use App\HourBlock;
use App\AvailabilityType;
use Illuminate\Support\Facades\Auth; //to get the loggedin user
use Illuminate\Support\Facades\Validator; // to use custom rules in the validator
use Illuminate\Support\Facades\Log; // Import the Log facade
use Carbon\Carbon; // to use the carbon methods (casts, addDay(), now(), etc)


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
    public function index($id)
    {
        //vars for content
        $user = User::find($id);
        $editNotes = $user->user_type_id == 2 ? true : false;
        $userId = $user->id;
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

            'showNotes',
            'editNotes',
            'showLegend',
            'showBtnStore',
            'objectName',
            'jsonTeacherAvailabilities',
            'userId'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $userId = $id;

        $teacherAvailabilities = TeacherAvailability::with('hourBlock', 'availabilityType')
        ->where('user_id', $userId)
        // The "when" method conditionally adds constraints to the query builder.
        // It checks the first parameter (user is type 1 planeamento) and if true, 
        // applies the closure provided as the second parameter to the query.
        ->when(Auth::user()->user_type_id !== 1, function ($query) {
            return $query->where('is_locked', '!=', 1);
        })
        ->get();
        
        //group by expects a string not date so we need to cast
        $teacherAvailabilitiesGroupedByDate = $teacherAvailabilities->groupBy(function($date) {
            return Carbon::parse($date->availability_date)->format('Y-m-d'); // using a fixed format
        })->sortBy(function ($dateGroup, $date) {// Sort by the date
            return $date; 
        })->map(function ($availabilitiesForDate) {// Sort the hour_blocks inside the date groups
            return $availabilitiesForDate->sortBy(function ($availability) {
                return $availability->hourBlock->hour_beginning;
            });
        });

        $hourBlocks = HourBlock::all();
        $availabilityTypes = AvailabilityType::all();

        $isEditing = false;

        //only in use for edit so that we can populate edit form with values from scheduler
        $teacherAvailability = null;

        return view('pages.teacher_availabilities.crud',
        compact(
            'teacherAvailability',
            'teacherAvailabilitiesGroupedByDate',
            'hourBlocks',
            'availabilityTypes',
            'isEditing',
            'userId'
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
        $this->detectIntrusion($request);

        $rules = [
            'user_id' => 'required|exists:users,id',
            'start_date' => 'required|date|after:today',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'start_hour_block_id' => 'required|exists:hour_blocks,id',
            'end_hour_block_id' => 'nullable|exists:hour_blocks,id',
            'availability_type_id' => 'required|exists:availability_types,id',
        ];

        //so that if the is not the same then the GTE - greater or equal does not apply
        //this '.=' adds the rule if the dates are the same
        if ($request->input('start_date') === $request->input('end_date')) {
            $rules['end_hour_block_id'] .= '|gte:start_hour_block_id';
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

            // If only start date is provided, handle single date entry. It cannot be with the ->has() method
            if (is_null($request->input('end_date')) || empty(trim($request->input('end_date')))) {
                $this->updateOrCreateSingleEntry($request, $startDate);
            } else {
                $endDate = Carbon::parse($request->end_date);
                $this->updateOrCreateDateRange($request, $startDate, $endDate);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        $userId = $request->user_id;
        return redirect()->route('teacher-availabilities.create', ['id' => $userId])
                 ->with('success', 'Disponibilidades criadas ou atualizadas com sucesso.');
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
    public function edit($id, $userId)
    {

        //in the case of planning the user id will be fetched from a table
        $userId = ($userId == "null" ? null : $userId) ?? Auth::user()->id;
        $teacherAvailability = TeacherAvailability::find($id);

        if (!$teacherAvailability) {
            return redirect()->back()->with('error', 'Disponibilidade não encontrada.');
        }

        $teacherAvailabilities = TeacherAvailability::with('hourBlock', 'availabilityType')
        ->where('user_id', $userId)
        // The "when" method conditionally adds constraints to the query builder.
        // It checks the first parameter (user is type 1 planeamento) and if true, 
        // applies the closure provided as the second parameter to the query.
        ->when(Auth::user()->user_type_id !== 1, function ($query) {
            return $query->where('is_locked', '!=', 1);
        })
        ->get();
        
        //group by expects a string not date so we need to cast
        $teacherAvailabilitiesGroupedByDate = $teacherAvailabilities->groupBy(function($date) {
            return Carbon::parse($date->availability_date)->format('Y-m-d'); // using a fixed format
        })->sortBy(function ($dateGroup, $date) {// Sort by the date
            return $date; 
        })->map(function ($availabilitiesForDate) {// Sort the hour_blocks inside the date groups
            return $availabilitiesForDate->sortBy(function ($availability) {
                return $availability->hourBlock->hour_beginning;
            });
        });

        $hourBlocks = HourBlock::all();
        $availabilityTypes = AvailabilityType::all();

        $isEditing = true;

        return view('pages.teacher_availabilities.crud',
        compact(
            'teacherAvailability',
            'teacherAvailabilitiesGroupedByDate',
            'hourBlocks',
            'availabilityTypes',
            'isEditing',
            'userId'
        ));
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
        $this->detectIntrusion($request);

        // Check for published availability and user type permission to edit
        $teacherAvailability = TeacherAvailability::find($id);

        if ($teacherAvailability->is_locked && auth()->user()->user_type_id !== 1) {
            return redirect()->back()->with('error', 'Alguns dos registos já se encontram publicados e não permitem edições.');
        }

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'availability_date' => 'required|date|after:today',
            'hour_block_id' => 'required|exists:hour_blocks,id',
            'availability_type_id' => 'required|exists:availability_types,id',
        ],
        [
            'user_id.required' => 'O campo de utilizador é obrigatório.',
            'user_id.exists' => 'O utilizador selecionado não é válido.',
            'availability_date.required' => 'A data de disponibilidade é obrigatória.',
            'availability_date.date' => 'A data de disponibilidade não é válida.',
            'availability_date.after' => 'A data de disponibilidade deve ser após hoje.',
            'hour_block_id.required' => 'O bloco de hora é obrigatório.',
            'hour_block_id.exists' => 'O bloco de hora selecionado não é válido.',
            'hour_block_id.unique' => 'Já existe uma disponibilidade para o bloco de hora e data selecionados.',
            'availability_type_id.required' => 'O tipo de disponibilidade é obrigatório.',
            'availability_type_id.exists' => 'O tipo de disponibilidade selecionado não é válido.',
        ]);

        $teacherAvailability->update($request->all());

        $userId = $request->user_id;
        return redirect()->route('teacher-availabilities.create', ['id' => $userId])
                 ->with('success', 'Disponibilidades atualizadas com sucesso.');
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
        $this->detectIntrusion($request);

        // Check for null or empty ids
        $ids = $request->input('ids');
        if (!$ids || !count($ids)) {
            return redirect()->back()->with('error', 'Nenhum registo seleccionado para apagar.');
        }

        try {
            TeacherAvailability::whereIn('id', $request->input('ids'))->delete();
            return redirect()->back()->with('success', 'Registos apagados.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao apagar os registos.');
        }
    }

    public function publishSelected(Request $request)
    {
        $this->detectIntrusion($request);

        // Check for null or empty ids
        $ids = $request->input('ids');
        if (!$ids || !count($ids)) {
            return redirect()->back()->with('error', 'Nenhum registo seleccionado para publicar.');
        }

        try {
            TeacherAvailability::whereIn('id', $request->input('ids'))->update(['is_locked' => true]);
            return redirect()->back()->with('success', 'Resgistos publicados.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao publicar os registos.');
        }
    }
    
    /**
     * Auxiliary method to create () Handle the single date entry.
     */
    private function updateOrCreateSingleEntry($request, $date)
    {
        
        $hourBlock = HourBlock::findOrFail($request->start_hour_block_id);
        
        // Check for published availability and user type permission to edit
        $existingAvailability = TeacherAvailability::where([
            'user_id' => $request->user_id,
            'availability_date' => $date->toDateString(),
            'hour_block_id' => $hourBlock->id,
            ])->first();
            
            if ($existingAvailability && $existingAvailability->is_locked && auth()->user()->user_type_id !== 1) {
                throw new \Exception('Alguns dos registos já se encontram publicados e não permitem edições.');
        }
        
        //UPDATE OR CREATE
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
        $startHourBlock = HourBlock::findOrFail($request->start_hour_block_id);
        $endHourBlock = HourBlock::findOrFail($request->end_hour_block_id);
        
        // Gather all the hour block IDs
        $hourBlockIds = HourBlock::whereBetween('id', [$startHourBlock->id, $endHourBlock->id])
            ->pluck('id')
            ->toArray();
            
        // Get all dates in the range.
        $dates = [];
        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            $dates[] = $date->toDateString();
        }
        
        // Check for any locked availabilities for the entire date and hour block range.
        $lockedRecords = TeacherAvailability::where('user_id', $request->user_id)
            ->whereIn('availability_date', $dates)
            ->whereIn('hour_block_id', $hourBlockIds)
            ->where('is_locked', 1)
            ->count();
        
        if ($lockedRecords > 0 && auth()->user()->user_type_id !== 1) {
            throw new \Exception('Alguns dos registos já se encontram publicados e não permitem edições.');
        }
        
        // If there are no locked records, proceed to update or create the entries.
        foreach ($dates as $date) {
            foreach ($hourBlockIds as $hourBlockId) {
                TeacherAvailability::updateOrCreate(
                    [
                        'user_id' => $request->user_id,
                        'availability_date' => $date,
                        'hour_block_id' => $hourBlockId,
                    ],
                    [
                        'availability_type_id' => $request->availability_type_id,
                    ]
                );
            }
        }
    }
        
    /**
     * Detects unauthorized intrusion attempts based on user type and user ID.
     *
     * If an intrusion is detected:
     * - The user's session is terminated.
     * - An alert log is created with the IP address of the intruder.
     * - A 403 Forbidden response is returned.
     *
     * @param  \Illuminate\Http\Request  $request  The incoming HTTP request instance.
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException  When an unauthorized action is detected.
     * @return void
     */
    private function detectIntrusion($request)
    {
        if (auth()->user()->user_type_id !== 1 && auth()->user()->id != $request->user_id)
        {
            // End user's session
            Auth::logout();
            
            // Log the intrusion
            $ipAddress = $request->ip();
            \Log::channel('intrusion')->alert("Intrusion Alert! Unauthorized access attempt from IP: $ipAddress");
            
            // Send 403 Forbidden response
            abort(403, 'Unauthorized action.');
        }
    }   
}
    