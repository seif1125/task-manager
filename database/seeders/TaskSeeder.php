<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Instantiate Faker
        $faker = Faker::create();


        $statuses = ['open', 'in progress', 'completed']; // Ensure these match your migration
        // Generate 50 tasks for each user

            for ($i = 0; $i < 100; $i++) {
                DB::table('tasks')->insert([
                    'user_id' => rand(1, 3),// Assign task to a random user
                    'title' => $faker->sentence,
                    'description' => $faker->paragraph,
                    'due_date' => Carbon::now()->addDays(rand(1, 30)), // Random due date between 1 and 30 days
                   'status' => $statuses[array_rand($statuses)],

                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

