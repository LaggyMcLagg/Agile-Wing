<?php

use Illuminate\Database\Seeder;

class PedagogicalGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $groups = [
            ['name' => 'REDES, SISTEMAS OPERATIVOS E SEGURANÇA'],
            ['name' => 'PROGRAMAÇÃO E BASES DE DADOS'],
            ['name' => 'TIC'],
            ['name' => 'GESTÃO INDUSTRIAL'],
            ['name' => 'MECÂNICA INDUSTRIAL'],
            ['name' => 'ELETRICIDADE'],
            ['name' => 'ELETRICIDADE E ENERGIA'],
            ['name' => 'REFRIGERAÇÃO E CLIMATIZAÇÃO'],
            ['name' => 'AUTOMAÇÃO, DOMÓTICA E ROBÓTICA'],
            ['name' => 'AUTOMÓVEL'],
            ['name' => 'SOLDADURA'],
            ['name' => 'INGLÊS'],
            ['name' => 'MUNDO ACTUAL+DSP+PRA+CP'],
            ['name' => 'MATEMÁTICA + STC'],
            ['name' => 'PORTUGUÊS + CLC'],
            ['name' => 'FÍSICA E QUÍMICA'],
        ];

        foreach ($groups as &$group) {
            $group['created_at'] = now();
            $group['updated_at'] = now();
        }

        DB::table('pedagogical_groups')->insert($groups);
    }
}
