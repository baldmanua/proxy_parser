<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpysOneFilterSetsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $filter_sets = [];
        for($xf1 = 1; $xf1 <= 4; $xf1++) {
            for($xf2 = 1; $xf2 <= 2; $xf2++) {
                for($xf4 = 1; $xf4 <= 3; $xf4++) {
                    for($xf5 = 1; $xf5 <= 2; $xf5++) {
                        $filter_sets[] = [
                            'xpp' => env('SPYS_PARSER_XPP', 5),
                            'xf1' => $xf1,
                            'xf2' => $xf2,
                            'xf3' => env('SPYS_PARSER_XF3', 0),
                            'xf4' => $xf4,
                            'xf5' => $xf5,
                            'status' => 'Newer parsed',
                            'created_at' => now()
                        ];
                    }
                }
            }
        }
        DB::table('spys_one_filter_sets')->insert($filter_sets);
    }
}
