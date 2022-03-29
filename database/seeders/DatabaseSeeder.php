<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // users
        DB::table('users')->insert([
            'name' => 'Mary',
            'email' => 'mary@gmail.com',
            'password' => bcrypt('mary')
        ]);
        // feeds
        DB::table('feeds')->insert([
            'user_id' => 1,
            'description' => 'About Description Feed',
            'image' => 'feed/logo.png'
        ]);
        // comments
        DB::table('comments')->insert([
            'user_id' => 1,
            'feed_id' => 1,
            'comment' => 'Hello Guys Commenting'
        ]);
        // likes
        DB::table('likes')->insert([
            'user_id' => 1,
            'feed_id' => 1,
        ]);
    }
}
