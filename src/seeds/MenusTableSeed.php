<?php

namespace Filmoteca\StaticPages;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Faker\Factory;
use DB;

class MenusTableSeed extends Seeder
{
    public function run()
    {
        $tableName          = 'filmoteca_menus';
        $entriesTableName   = 'filmoteca_menu_entries';
        $entriesAmount      = 6;
        $faker              = Factory::create('es_ES');

        $menu = [
            'name' => 'Main Menu',
            'created_at' => Carbon::now('UTC'),
            'updated_at' => Carbon::now('UTC')
        ];

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table($tableName)->truncate();
        $id = DB::table($tableName)->insertGetId($menu);

        $entries = [];

        for ($i = 1; $i <= $entriesAmount; $i++) {
            $entries[] = [
                'label'     => $faker->words(3, true),
                'position'  => $i,
                'url'       => $faker->url,
                'menu_id'   => $id,
                'created_at' => Carbon::now('UTC'),
                'updated_at' => Carbon::now('UTC')
            ];
        }
        DB::table($entriesTableName)->truncate();
        DB::table($entriesTableName)->insert($entries);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
