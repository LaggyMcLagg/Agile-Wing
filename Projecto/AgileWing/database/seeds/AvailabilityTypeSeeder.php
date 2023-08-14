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
            ['name' => 'Indisponível (Outra Entidade/Outros)'],
            ['name' => 'Indisponível (ATEC - ONLINE)'],
            ['name' => 'Indisponível (ATEC - PRESENCIAL)'],
            ['name' => 'Disponível'],
        ];

        foreach ($availabilityTypes as &$availabilityType) {
            $availabilityType['created_at'] = now();
            $availabilityType['updated_at'] = now();
        }

        DB::table('availability_types')->insert($availabilityTypes);
    }
}
