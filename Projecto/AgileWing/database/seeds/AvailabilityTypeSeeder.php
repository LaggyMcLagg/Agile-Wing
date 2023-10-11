<?php

use Illuminate\Database\Seeder;

class AvailabilityTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $availabilityTypes = [
            ['name' => 'Indisponível (Outra Entidade/Outros)',
            'color' => '#F53729'],
            ['name' => 'Disponível (ATEC - ONLINE)',
            'color' => '#F8E700'],
            ['name' => 'Disponível (ATEC - PRESENCIAL)',
            'color' => '#FFA500'],
            ['name' => 'Disponível',
            'color' => '#6AA84F'],
        ];

        foreach ($availabilityTypes as &$availabilityType) {
            $availabilityType['created_at'] = now();
            $availabilityType['updated_at'] = now();
        }

        DB::table('availability_types')->insert($availabilityTypes);
    }
}
