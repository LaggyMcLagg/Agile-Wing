<?php

use Illuminate\Database\Seeder;
use App\SpecializationArea;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $courses = [
            ['Fundamentos de Ciência da Computação', 'FCC'],
            ['Princípios de Metalurgia', 'PM'],
            ['Introdução à Engenharia Elétrica', 'IEE'],
            ['Noções de Eletrónica e Automação', 'NEA'],
            ['Oficina de Manutenção de Veículos', 'OMV'],
            ['Programação em Linguagem C', 'PLC'],
            ['Projeto de Circuitos Eletrónicos', 'PCE'],
            ['Mecânica e Dinâmica de Máquinas', 'MDM'],
            ['Automação Industrial Avançada', 'AIA'],
            ['Gestão de Projetos de Construção', 'GPC'],
        ];

        $specializationAreaIds = SpecializationArea::pluck('id');

        foreach ($courses as $course) {
            DB::table('courses')->insert([
                'name'                       => $course[0],
                'initials'                   => $course[1],
                'specialization_area_id' => $specializationAreaIds->random(),
                'created_at'                 => now(),
                'updated_at'                 => now(),
            ]);
        }
    }
}
