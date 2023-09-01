<?php

use Illuminate\Database\Seeder;

class HourBlockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $hourBlocks = [
            ['hour_beginning' => '08:15', 'hour_end' => '10:40', 'created_at' => now(), 'updated_at' => now(),],
            ['hour_beginning' => '10:40', 'hour_end' => '12:40', 'created_at' => now(), 'updated_at' => now(),],
            ['hour_beginning' => '12:40', 'hour_end' => '13:30', 'created_at' => now(), 'updated_at' => now(),],
            ['hour_beginning' => '13:30', 'hour_end' => '15:30', 'created_at' => now(), 'updated_at' => now(),],
            ['hour_beginning' => '14:40', 'hour_end' => '15:55', 'created_at' => now(), 'updated_at' => now(),],
            ['hour_beginning' => '14:40', 'hour_end' => '16:40', 'created_at' => now(), 'updated_at' => now(),],
            ['hour_beginning' => '16:50', 'hour_end' => '19:10', 'created_at' => now(), 'updated_at' => now(),],
            ['hour_beginning' => '19:10', 'hour_end' => '21:15', 'created_at' => now(), 'updated_at' => now(),],
            ['hour_beginning' => '21:15', 'hour_end' => '23:30', 'created_at' => now(), 'updated_at' => now(),],
        ];

        DB::table('hour_blocks')->insert($hourBlocks);
    }
}
