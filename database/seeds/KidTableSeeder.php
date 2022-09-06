<?php

use Illuminate\Database\Seeder;

class KidTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Kid::class, 50)->create()
            ->each(function (\App\Kid $kid){
                $kid->classrooms()->saveMany(\App\Classroom::inRandomOrder()->limit('10')->get());
            });
    }
}
