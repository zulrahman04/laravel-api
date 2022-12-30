<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            [  
                'name' => 'Startup',
                'slug' => 'Startup'
            ],
            [  
                'name' => 'Life',
                'slug' => 'Life'
            ],
            [  
                'name' => 'Life Leasons',
                'slug' => 'Life Leasons'
            ],
            [  
                'name' => 'Travel',
                'slug' => 'Travel'
            ],
            [  
                'name' => 'Education',
                'slug' => 'Education'
            ],

        ]);
    }
}
