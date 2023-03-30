<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        for($i=1; $i<6; $i++){
            DB::table("books")->insert([
                'book_title' => $faker->title(),
                'book_type' => $faker->title(),
                'book_author' => $faker->name(),
                'book_description' => $faker->text(),
                'book_isbn' => $faker->numberBetween(),

            ]);
        }
        
    }
}
