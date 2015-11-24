<?php

namespace Filmoteca\StaticPages;

use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use DB;

class StaticPagesTableSeed extends Seeder
{
    public function run()
    {
        $tableName  = 'filmoteca_static_pages';
        $amount     = pow(10, 1);
        $faker      = Factory::create('es_ES');
        $staticPages = [];

        $faker->seed(1234);

        for ($i = 0; $i < $amount; $i++) {
            $random         = rand(0, $i);
            $title          = $faker->sentence(6) . $i;
            $staticPages[]  = [
                'title'             => $title,
                'content'           => $faker->text(),
                'status'            => 'publish',
                'parent_page_id'    => $random > 0? $random: null,
                'slug'              => Str::slug($title),
                'created_at'        => Carbon::now('UTC'),
                'updated_at'        => Carbon::now('UTC')->addDay(rand(0, 10))
            ];
        }

        DB::table($tableName)->truncate();
        DB::table($tableName)->insert($staticPages);
    }
}
