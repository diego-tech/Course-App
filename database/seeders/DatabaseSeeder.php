<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i < 15; $i++) {
            DB::table('users')->insert([
                'name' => Str::random(20),
                'email' => Str::random(10) . '@gmail.com',
                'password' => Str::random(15),
                'photo' => Str::random(6) . '.png',
                'active' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);

            DB::table('courses')->insert([
                'title' => Str::random(20),
                'description' => Str::random(50),
                'course_thumbnail' => Str::random(6) . '.png',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);

            DB::table('videos')->insert([
                'title' => Str::random(20),
                'video_thumbnail' => Str::random(6) . '.png',
                'videolink' => Str::random(10) . '.mp4',
                'course_id' => rand(1, $i),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);

            DB::table('users_courses')->insert([
                'user_id' => rand(1, $i),
                'course_id' => rand(1, $i),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
        }
    }
}
