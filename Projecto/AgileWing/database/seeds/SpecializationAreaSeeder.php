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
            ['number' => 481, 'name' => 'Ciências Informáticas', 'created_at' => now(), 'updated_at' => now(),],
            ['number' => 521, 'name' => 'Metalurgia e Metalomecânica', 'created_at' => now(), 'updated_at' => now(),],
            ['number' => 522, 'name' => 'Eletricidade e Energia', 'created_at' => now(), 'updated_at' => now(),],
            ['number' => 523, 'name' => 'Eletrónica e Automação', 'created_at' => now(), 'updated_at' => now(),],
            ['number' => 525, 'name' => 'Construção e Reparação de Veículos a Motor', 'created_at' => now(), 'updated_at' => now(),],
        ];

        DB::table('specialization_areas')->insert($areas);
    }
}
