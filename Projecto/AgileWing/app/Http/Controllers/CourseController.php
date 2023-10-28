<?php

namespace App\Http\Controllers;

use App\Course;
use App\Ufcd;
use App\SpecializationArea;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses = Course::with('specializationArea', 'courseClasses', 'ufcds')->get();

        $ufcds = Ufcd::all();
        $specializationAreas = SpecializationArea::all();

        return view('pages.courses.crud', compact('courses', 'ufcds', 'specializationAreas'));
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
        $request->validate(
            [
                'name' => 'required|string|max:255|regex:/^[\pL\sÇç]+$/u',
                'initials' => 'required|string|max:255|regex:/^[A-ZÇ]+$/u',
                'specialization_area_number' => 'required|integer',
                'ufcds' => 'required|array',
                'ufcds.*' => 'exists:ufcds,id',
            ],
            [
                'name.required' => 'O campo nome é obrigatório.',
                'name.regex' => 'O nome só pode conter letras, acentuação e Ç ou ç.',
                'initials.required' => 'O campo iniciais é obrigatório.',
                'initials.regex' => 'As iniciais só podem conter letras maiúsculas e Ç.',
                'specialization_area_number.required' => 'O número da Área de Formação é obrigatório.',
                'ufcds.required' => 'Deve selecionar pelo menos uma UFCD.',
                'ufcds.*.exists' => 'Uma ou mais UFCDs selecionadas não existem.',

            ]
        );

        try {
            // Get the specialization_area_id using the unique number
            $specializationArea = SpecializationArea::where('number', $request->specialization_area_number)->first();

            if (!$specializationArea) {
                throw new \Exception("Specialization area not found for number: " . $request->specialization_area_number);
            }

            $course = Course::create([
                'name' => $request->name,
                'initials' => $request->initials,
                'specialization_area_id' => $specializationArea->id,
            ]);

            $course->ufcds()->attach($request->ufcds);

            return redirect()->route('courses.index')->with('success', 'Course created successfully');

        } catch (\Exception $e) {
            //This way we resolve gracefully any errors, return the error message the old form data
            session()->flash('error', 'There was an error creating the course: ' . $e->getMessage());
            return back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255|regex:/^[\pL\sÇç]+$/u',
                'initials' => 'required|string|max:255|regex:/^[A-ZÇ]+$/u',
                'specialization_area_number' => 'required|integer|exists:specialization_areas,number',
                'ufcds' => 'required|array',
                'ufcds.*' => 'exists:ufcds,id',
            ],
            [
                'name.required' => 'O campo nome é obrigatório.',
                'name.regex' => 'O nome só pode conter letras, acentuação e Ç ou ç.',
                'initials.required' => 'O campo iniciais é obrigatório.',
                'initials.regex' => 'As iniciais só podem conter letras maiúsculas e Ç.',
                'specialization_area_number.required' => 'O número da Área de Formação é obrigatório.',
                'specialization_area_number.exists' => 'O número da Área de Formação inserido não existe.',
                'ufcds.required' => 'Deve selecionar pelo menos uma UFCD.',
                'ufcds.*.exists' => 'Uma ou mais UFCDs selecionadas não existem.',

            ]
        );

        try {
            // Get the specialization_area_id using the unique number
            $specializationArea = SpecializationArea::where('number', $request->specialization_area_number)->first();

            if (!$specializationArea) {
                throw new \Exception("Specialization area not found for number: " . $request->specialization_area_number);
            }

            $course = Course::find($id);

            $course->update([
                'name' => $request->name,
                'initials' => $request->initials,
                'specialization_area_id' => $specializationArea->id,
            ]);

            $course->ufcds()->sync($request->ufcds);
        
            return redirect()->route('courses.index')->with('success', 'Course editado com sucesso.');
        } catch (\Exception $e) {
            //This way we resolve gracefully any errors, return the error message the old form data
            session()->flash('error', 'Houve um erro a editar o curso. ' . $e->getMessage());
            return back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        try {
            // Soft delete the entries in the pivot table
            \DB::table('course_ufcds')
                ->where('course_id', $course->id)
                ->update(['deleted_at' => now()]);

            // Soft delete the course
            $course->delete();
    
            return redirect()->route('courses.index')->with('success', 'Curso apagado com sucesso');
        } catch (\Exception $e) {            
    
            return redirect()->route('courses.index')->with('error', 'Houve um erro a apagar o curso.' . $e->getMessage());
        }
    }
}
