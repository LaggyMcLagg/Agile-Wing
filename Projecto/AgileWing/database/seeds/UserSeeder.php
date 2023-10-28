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
                'name'              => 'Carmen Teixeira',
                'email'             => 'carmen.teixeira@edu.atec.pt',
                'email_verified_at' => now(), 
                'password'          =>  bcrypt('password'),
                'user_type_id'      => 1,
                'token_password'    => bcrypt(Str::random(10)),
                'token_created_at'  => now(),
                'last_login'        => now(),
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
            [
                'name'              => 'Planeamento Lisboa',
                'email'             => 'planeamento.lx@edu.atec.pt',
                'email_verified_at' => now(), 
                'password'          =>  bcrypt('password'), 
                'user_type_id'      => 1,
                'token_password'    => bcrypt(Str::random(10)),
                'token_created_at'  => now(),
                'last_login'        => now(),
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
            
        ]);

        for ($i = 1; $i <= 50; $i++) {
            $color1 = $this->faker->hexcolor();
            $color2 = $this->getDifferentShade($color1);

            factory(User::class)->create([
                'color_1' => $color1,
                'color_2' => $color2,
            ]);
        }
    }
    
    /**
    * Generate a slightly different shade of a hexadecimal color.
    *
    * This function takes a hexadecimal color code as input and calculates a
    * new color that is slightly different than the original color. The degree
    * in which it varies is controlled by adding a fixed value to the individual
    * Red, Green, and Blue (RGB) components of the color. However, for components
    * that have a value greater than 195, the function will subtract 60 instead of
    * adding, to prevent the color from getting excessively light. If any component
    * value exceeds 255 or goes below 0, it is clamped within the range [0, 255].
    *
    * @param string $color The hexadecimal color code (e.g., "#RRGGBB").
    * @return string The new hexadecimal color code of the lighter shade.
    */
    protected function getDifferentShade($color)
    {
        $lighter = function ($val) {

            if($val >195){
                return  $val-60;
            }

            return $val+60;
        };

        list($r, $g, $b) = sscanf($color, "#%02x%02x%02x");
        $r = $lighter($r);
        $g = $lighter($g);
        $b = $lighter($b);

        return sprintf("#%02x%02x%02x", $r, $g, $b);
    }
}
