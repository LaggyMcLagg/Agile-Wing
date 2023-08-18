<?php

use Illuminate\Database\Seeder;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;


class UserSeeder extends Seeder
{
    protected $faker;

    public function __construct(Faker $faker)
    {
        $this->faker = $faker;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Carmen Teixeira',
                'email' => 'carmen.teixeira@edu.atec.pt',
                'password' =>  bcrypt('password'),
                'user_type_id' => 1,
                'token_password' => bcrypt(Str::random(10)),
                'token_used' => true,
                'token_created_at' => now(),
                'remember_token' => Str::random(10),
                'last_login' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Professor Beterraba',
                'email' => 'prof.beterraba@edu.atec.pt',
                'password' =>  bcrypt('password'), 
                'user_type_id' => 1,
                'token_password' => bcrypt(Str::random(10)),
                'token_used' => true,
                'token_created_at' => now(),
                'remember_token' => Str::random(10),
                'last_login' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        for ($i = 1; $i <= 50; $i++) {
            $color1 = $this->faker->hexcolor();
            $color2 = $this->getLighterShade($color1);

            factory(User::class)->create([
                'color_1' => $color1,
                'color_2' => $color2,
            ]);
        }
    }
    
    /**
     * Generate a slightly lighter shade of a hexadecimal color.
     *
     * This function takes a hexadecimal color code as input and calculates a
     * new color that is slightly lighter than the original color. The degree
     * of lightening is controlled by adding a fixed value to the individual
     * Red, Green, and Blue (RGB) components of the color. If any component
     * value exceeds 255, it is capped at 255 to ensure the color remains
     * within the valid range.
     *
     * @param string $color The hexadecimal color code (e.g., "#RRGGBB").
     * @return string The new hexadecimal color code of the lighter shade.
     */
    protected function getLighterShade($color)
    {
        $lighter = function ($val) {
            return min(255, $val + 60);
        };

        list($r, $g, $b) = sscanf($color, "#%02x%02x%02x");
        $r = $lighter($r);
        $g = $lighter($g);
        $b = $lighter($b);

        return sprintf("#%02x%02x%02x", $r, $g, $b);
    }
}
