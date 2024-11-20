<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Fetch all task and user IDs
        $taskIds = DB::table('tasks')->pluck('id')->toArray();
        $userIds = DB::table('users')->pluck('id')->toArray();

        // Seed 200 random comments
        for ($i = 0; $i < 200; $i++) {
            DB::table('comments')->insert([
                'content' => $faker->sentence(rand(5, 15)), // Random content for comments
                'user_id' => $faker->randomElement($userIds), // Random user from users table
                'task_id' => $faker->randomElement($taskIds), // Random task from tasks table
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

    }
}
