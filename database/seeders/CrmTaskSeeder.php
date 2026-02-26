<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class CrmTaskSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        $userIds    = DB::table('users')->pluck('id')->toArray();
        $statuses   = ['Todo', 'In Progress', 'Under Review', 'Completed'];
        $priorities = ['Low', 'Medium', 'High', 'Urgent'];
        $categories = ['Development', 'Design', 'Marketing', 'Support', 'Research', 'Admin', 'Sales', 'Finance'];

        $tasks = [];
        for ($i = 0; $i < 30; $i++) {
            $start = $faker->dateTimeBetween('-6 months', 'now');
            $tasks[] = [
                'title'       => $faker->sentence(4),
                'category'    => $faker->randomElement($categories),
                'start_date'  => $start->format('Y-m-d'),
                'due_date'    => $faker->dateTimeBetween($start, '+3 months')->format('Y-m-d'),
                'tags'        => implode(',', $faker->randomElements(['urgent', 'review', 'blocked', 'easy', 'quick-win'], $faker->numberBetween(1, 2))),
                'priority'    => $faker->randomElement($priorities),
                'status'      => $faker->randomElement($statuses),
                'description' => $faker->optional(0.6)->paragraph,
                'created_at'  => $faker->dateTimeBetween('-6 months', 'now'),
                'updated_at'  => now(),
            ];
        }

        DB::table('crm_tasks')->insert($tasks);

        $taskIds = DB::table('crm_tasks')->pluck('id')->toArray();
        $pivots = [];
        foreach ($taskIds as $taskId) {
            $pivots[] = ['task_id' => $taskId, 'user_id' => $faker->randomElement($userIds)];
        }
        DB::table('crm_task_responsible')->insert($pivots);
    }
}
