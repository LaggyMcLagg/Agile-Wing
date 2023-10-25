<?php

namespace App\Http\Controllers;

use App\AvailabilityType;
use App\CourseClass;
use App\ScheduleAtribution;
use App\Ufcd;
use App\User;
use Illuminate\Http\Request;
//cronogramaPDF
use App\HourBlockCourseClass;
use App\HourBlock;
use Carbon\Carbon;
use PDF;


class ScheduleAtributionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CourseClass $courseClass)
    {
        $scheduleAtributions = ScheduleAtribution::where('course_class_id', $courseClass->id)->get();
            
        return view('pages.schedule_atribution.index', compact('scheduleAtributions'));
    }
    
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(User $user)
    {
        $availabilityTypes = AvailabilityType::all();
        $courseClasses = CourseClass::all();
        $ufcds = Ufcd::all();
        $users = User::all();

        //if($user->user_type_id == 1) { //TODO descomentar
            return view('pages.schedule_atribution.create', compact('availabilityTypes', 'courseClasses', 'ufcds', 'users'));
        //} else {
            //return view('pages.error');
        //}
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        // Validar dados
        $request->validate([
            'date' => 'required|date|after:today',
            'hour_start' => 'required|date_format:H:i',
            'hour_end' => 'required|date_format:H:i',
            'availability_type_id' => 'required|exists:availability_types,id',
            'course_class_id' => 'required|exists:course_classes,id',
            'ufcd_id' => 'required|exists:ufcds,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $scheduleUser = User::find($request->user_id);

        $scheduleUser->scheduleAtributions()->create($request->all());

        return redirect()->route('schedule_atribution.index')->with('status', 'Schedule atribution created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ScheduleAtribution  $scheduleAtribution
     * @return \Illuminate\Http\Response
     */
    public function show(User $user, ScheduleAtribution $scheduleAtribution)
    {
        // Eager load the necessary relationships
        $scheduleAtribution->load('user', 'ufcd', 'courseClass', 'availabilityType');

        // Pass the data to the view
        return view('pages.schedule_atribution.show', compact('scheduleAtribution'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ScheduleAtribution  $scheduleAtribution
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user, ScheduleAtribution $scheduleAtribution)
    {
        $availabilityTypes = AvailabilityType::all();
        $courseClasses = CourseClass::all();
        $ufcds = Ufcd::all();
        $users = User::all();

        return view('pages.schedule_atribution.edit', compact('scheduleAtribution', 'availabilityTypes', 'courseClasses', 'ufcds', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ScheduleAtribution  $scheduleAtribution
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user, ScheduleAtribution $scheduleAtribution)
    {
        $request->validate([
            'date' => 'required|date|after:today',
            'hour_start' => 'required|date_format:H:i',
            'hour_end' => 'required|date_format:H:i',
            'availability_type_id' => 'required|exists:availability_types,id',
            'course_class_id' => 'required|exists:course_classes,id',
            'ufcd_id' => 'required|exists:ufcds,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $scheduleAtribution->update($request->all());

        return redirect()->route('schedule_atribution.index')->with('status', 'Schedule atribution updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ScheduleAtribution  $scheduleAtribution
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, ScheduleAtribution $scheduleAtribution)
    {
        $scheduleAtribution->delete();

        return redirect()->route('schedule_atribution.index', $user);
    }

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
        $classId = 5;

        //recupera a turma juntamente com seu curso e blocos de horário associados
        $courseClass = CourseClass::with([
            'course',
            'hourBlockCourseClasses.scheduleAtributions',
        ])->find($classId);

        //formata as atribuições de horário
        //$courseClass->hourBlockCourseClasses são os blocos de horário associados a cada turma
        //usamos o flatMap para iterar por cada bloco de horário associado à turma
        //dentro de flatMap, utilizamos o map para transformar cada bloco de horário numa coleção de atribuições de horário formatadas (scheduleAtributions)
        //o resultado de flatMap será uma única coleção que contém todas as atribuições de horário daquela turma, em vez de uma coleção de coleções separadas
        $allAtributions = $courseClass->hourBlockCourseClasses->flatMap(function ($hourBlockCourseClass) 
        {
            return $hourBlockCourseClass->scheduleAtributions->map(function ($scheduleAtribution) 
            {
                $scheduleAtribution->formattedDate = $scheduleAtribution->date->format('d/m/Y');
                return $scheduleAtribution;
            });
        });

        //ordena as atribuições pelo mês e depois pela data dentro do mês
        $allAtributions = $allAtributions->sortBy(function ($scheduleAtribution) 
        {
            return $scheduleAtribution->date->format('Ym') . $scheduleAtribution->date->format('d');
        });

        //agrupa as atribuições por mês/ano
        $atributionsByMonth = $allAtributions->groupBy(function ($scheduleAtribution) 
        {
            return $scheduleAtribution->date->format('m/Y');
        });

        $tables = [];

        foreach ($atributionsByMonth as $month => $atributions) 
        {
            //inicializa a tabela para o mês atual
            $table = [
                'month' => $month,
                'header' => [],
                'data' => [],
            ];

            $header = ['Horário'];

            //obtém todas as datas do mês
            $startDate = Carbon::createFromFormat('m/Y', $month)->startOfMonth();
            $endDate = Carbon::createFromFormat('m/Y', $month)->endOfMonth();

            while ($startDate->lte($endDate)) 
            {
                $header[] = $startDate->format('d/m/Y');
                $startDate->addDay();
            }

            $table['header'] = $header;

            //inicia a iteração pelos blocos de horário
            $data = [];

            foreach ($courseClass->hourBlockCourseClasses as $hourBlockCourseClass) 
            {
                $row = [
                    'hour' => $hourBlockCourseClass->hour_beginning . ' - ' . $hourBlockCourseClass->hour_end,
                    'data' => [],
                ];

                foreach ($header as $date) {
                    $column = [];

                    foreach ($allAtributions as $currentAtribution) 
                    {
                        //verifica se a atribuição coincide com a data e o bloco de horário atual
                        if ($currentAtribution->formattedDate === $date && $currentAtribution->hour_block_course_class_id == $hourBlockCourseClass->id) 
                        {
                            $column[] = [
                                'ufcd' => $currentAtribution->ufcd->number,
                                'name' => $currentAtribution->user->name,
                                'date' => $currentAtribution->date,
                            ];
                        }
                    }

                    $row['data'][] = $column;
                }

                $data[] = $row;
            }

            $table['data'] = $data;
            $tables[] = $table;
        }
        
        return view('pages.schedule_atribution.export-pdf', [
            'courseClass' => $courseClass,
            'tables' => $tables,
        ]);
    }

    public function exportTimelineToPDF()
    {
        $classId = 5;
        
        //recupera a turma juntamente com seu curso e blocos de horário associados
        $courseClass = CourseClass::with([
            'course',
            'hourBlockCourseClasses.scheduleAtributions',
        ])->find($classId);

        //formata as atribuições de horário
        //$courseClass->hourBlockCourseClasses são os blocos de horário associados a cada turma
        //usamos o flatMap para iterar por cada bloco de horário associado à turma
        //dentro de flatMap, utilizamos o map para transformar cada bloco de horário numa coleção de atribuições de horário formatadas (scheduleAtributions)
        //o resultado de flatMap será uma única coleção que contém todas as atribuições de horário daquela turma, em vez de uma coleção de coleções separadas
        $allAtributions = $courseClass->hourBlockCourseClasses->flatMap(function ($hourBlockCourseClass) 
        {
            return $hourBlockCourseClass->scheduleAtributions->map(function ($scheduleAtribution) 
            {
                $scheduleAtribution->formattedDate = $scheduleAtribution->date->format('d/m/Y');
                return $scheduleAtribution;
            });
        });

        //ordena as atribuições pelo mês e depois pela data dentro do mês
        $allAtributions = $allAtributions->sortBy(function ($scheduleAtribution) 
        {
            return $scheduleAtribution->date->format('Ym') . $scheduleAtribution->date->format('d');
        });

        //agrupa as atribuições por mês/ano
        $atributionsByMonth = $allAtributions->groupBy(function ($scheduleAtribution) 
        {
            return $scheduleAtribution->date->format('m/Y');
        });

        $tables = [];

        foreach ($atributionsByMonth as $month => $atributions) 
        {
            //inicializa a tabela para o mês atual
            $table = [
                'month' => $month,
                'header' => [],
                'data' => [],
            ];

            $header = ['Horário'];

            //obtém todas as datas do mês
            $startDate = Carbon::createFromFormat('m/Y', $month, 'UTC')->startOfMonth();
            $endDate = Carbon::createFromFormat('m/Y', $month, 'UTC')->endOfMonth();

            while ($startDate->lte($endDate)) 
            {
                $header[] = $startDate->format('d/m/Y');
                $startDate->addDay();
            }

            $table['header'] = $header;

            //inicia a iteração pelos blocos de horário
            $data = [];

            foreach ($courseClass->hourBlockCourseClasses as $hourBlockCourseClass) 
            {
                $row = [
                    'hour' => $hourBlockCourseClass->hour_beginning . ' - ' . $hourBlockCourseClass->hour_end,
                    'data' => [],
                ];

                foreach ($header as $date) {
                    $column = [];
                    
                    foreach ($allAtributions as $currentAtribution) 
                    {
                        //verifica se a atribuição coincide com a data e o bloco de horário atual
                        if ($currentAtribution->formattedDate === $date && $currentAtribution->hour_block_course_class_id == $hourBlockCourseClass->id) 
                        {
                            $column[] = [
                                'ufcd' => $currentAtribution->ufcd->number,
                                'name' => $currentAtribution->user->name,
                                'date' => $currentAtribution->date,
                            ]; 
                        }
                    }
                    
                    $row['data'][] = $column;
                }

                $data[] = $row;
            }

            $table['data'] = $data;
            $tables[] = $table;
            
        }

        // [$courseClass, $tables] = $this->timelineToPdf();
        $pdf = PDF::loadview('pages.schedule_atribution.export-pdf', compact('courseClass','tables'));
        return $pdf->download('cronograma.pdf');
    }
}

