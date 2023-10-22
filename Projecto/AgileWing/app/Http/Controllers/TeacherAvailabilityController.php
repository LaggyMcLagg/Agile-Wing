<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TeacherAvailability;
use App\User;
use App\HourBlock;
use App\AvailabilityType;
use Illuminate\Support\Facades\Auth; //to get the logged in user

//cronogramaPDF
use App\HourBlockCourseClass;
use App\ScheduleAtribution;
use App\CourseClass;
use App\Ufcd;
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

    public function scheduler()
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

        return view('pages.teacher_availabilities.scheduler', 
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

    public function timelineToPdf()
    {
        $ufcds = Ufcd::all();
        $hourBlocks = HourBlock::all();
        $users = User::whereHas('userType', function ($query) 
        {
            $query->where('name', 'professor');
        })->get();
    
        $beginningDate = Carbon::parse('2023-01-01');
        $endDate = Carbon::parse('2024-12-31');
    
        $year = $beginningDate->year;
    
        $months = $this->getMonthsInRange($beginningDate, $endDate);
        $daysOfWeek = ['Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'];
    
        $dates = [];
        $currentDate = $beginningDate->copy();
        $currentDayOfWeek = $currentDate->format('N');
    
        while ($currentDayOfWeek != 1) 
        {
            $dates[] = '';
            $currentDayOfWeek = $currentDayOfWeek % 7 + 1;
        }
    
        while ($currentDate <= $endDate) 
        {
            $dates[] = $currentDate->format('d/m');
            $currentDate->addDay();
        }
    
        return view('pages.schedule_atribution.export-pdf', [
            'ufcds'         => $ufcds,
            'hourBlocks'    => $hourBlocks,
            'users'         => $users,
            'months'        => $months,
            'year'          => $year,
            'dates'         => $dates,
            'daysOfWeek'    => $daysOfWeek,
        ]);
    }
    
    
    
    
    private function getMonthsInRange(Carbon $start, Carbon $end)
    {
        $months = [
            'Janeiro',
            'Fevereiro',
            'Março',
            'Abril',
            'Maio',
            'Junho',
            'Julho',
            'Agosto',
            'Setembro',
            'Outubro',
            'Novembro',
            'Dezembro',
        ];
    
        $monthsInRange = [];
    
        $currentMonth = $start->copy();
        while ($currentMonth <= $end) 
        {
            $monthsInRange[] = $months[$currentMonth->format('n') - 1] . ' ' . $currentMonth->year;
            $currentMonth->addMonth();
        }
    
        // Verifique se o último mês está dentro do intervalo
        if (end($monthsInRange) !== $months[$end->format('n') - 1] . ' ' . $end->year) 
        {
            $monthsInRange[] = $months[$end->format('n') - 1] . ' ' . $end->year;
        }
    
        return $monthsInRange;
    }
    
    
    
    
    
    public function Crud()
    {
        //
    }
}
