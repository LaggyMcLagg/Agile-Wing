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

    public function classTimeLineView()
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

            //preenche o array $header com datas formatadas 'd/m/Y' para representar os dias do mês
            while ($startDate->lte($endDate)) 
            {
                $header[] = $startDate->format('d/m/Y');
                $startDate->addDay();
            }

            //define o cabeçalho da tabela representada por $table, utilizando as datas formatadas do mês armazenadas em $header.
            $table['header'] = $header;

            //inicia a iteração pelos blocos de horário
            $data = [];

            //para cada bloco de horário associado à turma, cria uma nova linha representada por um array.
            //a linha contém informações sobre o horário, incluindo o horário de início e fim, e um array vazio chamado 'data' que vai ser preenchido em baixo
            foreach ($courseClass->hourBlockCourseClasses as $hourBlockCourseClass) 
            {
                $row = [
                    'hour' => $hourBlockCourseClass->hour_beginning . ' - ' . $hourBlockCourseClass->hour_end,
                    'data' => [],
                ];
            
                //itera por todas as datas no cabeçalho, começando da segunda data, já que a primeira é o título 'Horário'.
                foreach ($header as $key => $date) 
                {
                    if ($key == 0) continue; //ignora a primeira entrada do cabeçalho
                
                    //para armazenar informações sobre atribuições de horário para a data atual
                    $column = [];
                
                    //itera por todas as atribuições de horário disponíveis
                    foreach ($allAtributions as $currentAtribution) 
                    {
                        //verifica se a atribuição de horário coincide com a data atual e o bloco de horário atual
                        if ($currentAtribution->formattedDate === $date && $currentAtribution->hour_block_course_class_id == $hourBlockCourseClass->id) 
                        {
                            //se a atribuição coincidir, cria um array com informações como UFCD, nome do formador, data e cor
                            $column[] = [
                                'ufcd' => $currentAtribution->ufcd->number,
                                'name' => $currentAtribution->user->name,
                                'date' => $currentAtribution->date,
                                'color_1' => $currentAtribution->user->color_1,
                            ];
                        }
                    }

                    //adiciona o array column ao array data da linha atual, que representa a informação de atribuições de horário para a data atual
                    $row['data'][] = $column;
                }
                //adiciona a linha atual (representando um bloco de horário) ao array 'data'

                $data[] = $row;
            }
            //aassocia o array 'data' ao array 'table' para representar os dados da tabela
            $table['data'] = $data;
            //adiciona o array 'table' (representando a tabela de um mês) ao array 'tables'
            $tables[] = $table;
        }
        
        return view('pages.schedule_atribution.export-pdf-class', [
            'courseClass' => $courseClass,
            'tables' => $tables,
        ]);
    }

    public function classTimeLinePDF()
    {
        $classId = 5;
        
        $courseClass = CourseClass::with([
            'course',
            'hourBlockCourseClasses.scheduleAtributions',
        ])->find($classId);

        $allAtributions = $courseClass->hourBlockCourseClasses->flatMap(function ($hourBlockCourseClass) 
        {
            return $hourBlockCourseClass->scheduleAtributions->map(function ($scheduleAtribution) 
            {
                $scheduleAtribution->formattedDate = $scheduleAtribution->date->format('d/m/Y');
                return $scheduleAtribution;
            });
        });

        $allAtributions = $allAtributions->sortBy(function ($scheduleAtribution) 
        {
            return $scheduleAtribution->date->format('Ym') . $scheduleAtribution->date->format('d');
        });

        $atributionsByMonth = $allAtributions->groupBy(function ($scheduleAtribution) 
        {
            return $scheduleAtribution->date->format('m/Y');
        });

        $tables = [];

        foreach ($atributionsByMonth as $month => $atributions) 
        {
            $table = [
                'month' => $month,
                'header' => [],
                'data' => [],
            ];

            $header = ['Horário'];

            $startDate = Carbon::createFromFormat('m/Y', $month, 'UTC')->startOfMonth();
            $endDate = Carbon::createFromFormat('m/Y', $month, 'UTC')->endOfMonth();

            while ($startDate->lte($endDate)) 
            {
                $header[] = $startDate->format('d/m/Y');
                $startDate->addDay();
            }

            $table['header'] = $header;

            $data = [];

            foreach ($courseClass->hourBlockCourseClasses as $hourBlockCourseClass) 
            {
                $row = [
                    'hour' => $hourBlockCourseClass->hour_beginning . ' - ' . $hourBlockCourseClass->hour_end,
                    'data' => [],
                ];
            
                foreach ($header as $key => $date) 
                {
                    if ($key == 0) continue; // ignore the first header entry
                    $column = [];
                    foreach ($allAtributions as $currentAtribution) {
                        // verifica se a atribuição coincide com a data e o bloco de horário atual
                        if ($currentAtribution->formattedDate === $date && $currentAtribution->hour_block_course_class_id == $hourBlockCourseClass->id) 
                        {
                            $column[] = [
                                'ufcd' => $currentAtribution->ufcd->number,
                                'name' => $currentAtribution->user->name,
                                'date' => $currentAtribution->date,
                                'color_1' => $currentAtribution->user->color_1,
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

        $pdf = PDF::loadview('pages.schedule_atribution.export-pdf-class', compact('courseClass','tables'));
        return $pdf->download('cronograma.pdf');
    }

public function teacherTimeLineView()
{
    $userId = 11;

    $teacherClass = User::with([
        'scheduleAtributions',
        'scheduleAtributions.courseClass',
        'scheduleAtributions.hourBlockCourseClass',
        'scheduleAtributions.ufcd',
    ])->find($userId);

    // Sort the schedule attributions by date in ascending order
    $teacherClass->scheduleAtributions = $teacherClass->scheduleAtributions
        ->sortBy('date');

    $groupedAtributions = $teacherClass->scheduleAtributions->groupBy(function ($attribution) {
        return $attribution->date->format('Y-m-d'); // Group by complete date.
    });

    $dates = $groupedAtributions->keys(); // Get unique dates.

    return view('pages.schedule_atribution.export-pdf-teacher', [
        'teacherClass' => $teacherClass, 
        'dates' => $dates, 
        'groupedAtributions' => $groupedAtributions
    ]);
}

    

    public function teacherTimeLinePDF()
    {

    }
}

