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
            ['name' => 'Indisponível',
            'color' => '#F53729'],
            ['name' => 'Presencial',
            'color' => '#F8E700'],
            ['name' => 'Online',
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
