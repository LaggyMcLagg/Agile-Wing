<?php

use Illuminate\Database\Seeder;
use App\PedagogicalGroup;

class UfcdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ufcds = [
            ['number' => 6655, 'name' => 'A literatura do nosso tempo', 'hours' => 50],
            ['number' => 757, 'name' => 'Folha de cálculo - funcionalidades avançadas', 'hours' => 25],
            ['number' => 6654, 'name' => 'Ler a imprensa escrita', 'hours' => 25],
            ['number' => 6656, 'name' => 'Mudanças profissionais e mercado de trabalho', 'hours' => 25],
            ['number' => 6667, 'name' => 'Mundo atual - tema opcional', 'hours' => 25],
            ['number' => 6670, 'name' => 'Promoção da saúde', 'hours' => 25],
            ['number' => 6664, 'name' => 'Realizar uma exposição sobre as instituições internacionais', 'hours' => 50],
            ['number' => 6674, 'name' => 'Geometria e trigonometria', 'hours' => 50],
            ['number' => 6706, 'name' => 'Movimentos ondulatórios', 'hours' => 25],
            ['number' => 6675, 'name' => 'Padrões, funções e álgebra', 'hours' => 25],
            ['number' => 6709, 'name' => 'Reações de ácido-base e de oxidação-redução', 'hours' => 25],
            ['number' => 6710, 'name' => 'Reações de precipitação de equilíbrio heterogéneo', 'hours' => 25],
            ['number' => 5021, 'name' => 'Diagnostico e reparação de sistemas de carga e arranque', 'hours' => 25],
            ['number' => 5019, 'name' => 'Diagnóstico e reparação em sistemas de antipoluição / sobrealimentação', 'hours' => 50],
            ['number' => 5017, 'name' => 'Diagnóstico e reparação em sistemas de ignição e injecção electrónica de motores a gasolina', 'hours' => 50],
            ['number' => 5006, 'name' => 'Diagnóstico e reparação em sistemas de segurança activa e passiva', 'hours' => 50],
            ['number' => 5011, 'name' => 'Diagnóstico e reparação em sistemas de transmissão automática', 'hours' => 50],
            ['number' => 5013, 'name' => 'Motores - diagnóstico de avarias / informação técnica', 'hours' => 50],
            ['number' => 5012, 'name' => 'Motores - reparação / dados técnicos', 'hours' => 50],
            ['number' => 10859, 'name' => 'Sistemas de climatização nos veículos automóveis', 'hours' => 50],
            ['number' => 5016, 'name' => 'Sistemas de ignição e injecção electrónica de motores a gasolina', 'hours' => 50],
            ['number' => 10858, 'name' => 'Sistemas de Iluminação e aviso no automóvel', 'hours' => 25],
            ['number' => 1544, 'name' => 'Sistemas de injecção diesel', 'hours' => 25],
            ['number' => 1608, 'name' => 'Sistemas multiplexados', 'hours' => 25],
            ['number' => 833, 'name' => 'Equipamentos ativos de redes', 'hours' => 50],
            ['number' => 832, 'name' => 'Equipamentos passivos de redes', 'hours' => 50],
            ['number' => 838, 'name' => 'Linux - administração', 'hours' => 50],
            ['number' => 836, 'name' => 'Linux - instalação e configuração', 'hours' => 25],
            ['number' => 837, 'name' => 'Linux - kernel e componentes do sistema', 'hours' => 50],
            ['number' => 839, 'name' => 'Linux - serviços de redes', 'hours' => 50],
            ['number' => 834, 'name' => 'Linux - shell scripting', 'hours' => 25],
        ];

        foreach ($ufcds as $ufcd) {
            $pedagogical_group_id = PedagogicalGroup::all()->random()->id;

            DB::table('ufcds')->insert([
                'name'                  => $ufcd['name'],
                'pedagogical_group_id'  => $pedagogical_group_id,
                'number'                => $ufcd['number'],
                'hours'                 => $ufcd['hours'],
                'created_at'            => now(),
                'updated_at'            => now(),
            ]);
        }
    }
}
