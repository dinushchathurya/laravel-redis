<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BlogSeeder extends Seeder
{
    public function run()
    {
        DB::table('blogs')->insert([
            'title' => 'First Blog',
            'sub-header' => 'Sub Header One',
            'content' => 'Blog Content One'
        ]);
    }
}
