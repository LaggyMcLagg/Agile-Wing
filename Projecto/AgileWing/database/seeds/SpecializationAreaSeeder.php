<?php

use Illuminate\Database\Seeder;

class SpecializationAreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $areas = [
            ['number' => 481, 'name' => 'Ciências Informáticas'],
            ['number' => 521, 'name' => 'Metalurgia e Metalomecânica'],
            ['number' => 522, 'name' => 'Eletricidade e Energia'],
            ['number' => 523, 'name' => 'Eletrónica e Automação'],
            ['number' => 525, 'name' => 'Construção e Reparação de Veículos a Motor'],
        ];

        DB::table('specialization_areas')->insert($areas);
    }
}
