<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class CrmProjectSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        $clientIds   = DB::table('crm_contacts')->pluck('id')->toArray();
        $userIds     = DB::table('users')->pluck('id')->toArray();
        $statuses    = ['Not Started', 'In Progress', 'On Hold', 'Completed', 'Cancelled'];
        $priorities  = ['Low', 'Medium', 'High', 'Urgent'];
        $types       = ['Internal', 'External', 'Research', 'Development', 'Maintenance'];
        $timings     = ['Fixed', 'Hourly', 'Monthly Retainer', 'Milestone-based'];
        $categories  = ['Web Development', 'Mobile App', 'Data Analysis', 'Design', 'Marketing', 'Infrastructure', 'Consulting'];

        $projects = [];
        for ($i = 0; $i < 20; $i++) {
            $start = $faker->dateTimeBetween('-1 year', 'now');
            $projects[] = [
                'name'            => $faker->catchPhrase . ' Project',
                'project_id_code' => 'PRJ-' . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                'project_type'    => $faker->randomElement($types),
                'client_id'       => $faker->optional(0.8)->randomElement($clientIds),
                'category'        => $faker->randomElement($categories),
                'project_timing'  => $faker->randomElement($timings),
                'price'           => $faker->randomFloat(2, 5000, 500000),
                'start_date'      => $start->format('Y-m-d'),
                'due_date'        => $faker->dateTimeBetween($start, '+1 year')->format('Y-m-d'),
                'priority'        => $faker->randomElement($priorities),
                'status'          => $faker->randomElement($statuses),
                'description'     => $faker->optional(0.7)->paragraph,
                'created_at'      => $faker->dateTimeBetween('-1 year', 'now'),
                'updated_at'      => now(),
            ];
        }

        DB::table('crm_projects')->insert($projects);

        $projectIds = DB::table('crm_projects')->pluck('id')->toArray();

        $leaders = [];
        $responsibles = [];
        foreach ($projectIds as $projectId) {
            $leaders[] = ['project_id' => $projectId, 'user_id' => $faker->randomElement($userIds)];
            foreach ($faker->randomElements($userIds, min(2, count($userIds))) as $uid) {
                $responsibles[] = ['project_id' => $projectId, 'user_id' => $uid];
            }
        }
        DB::table('crm_project_leader')->insert($leaders);
        // De-duplicate responsibles
        $seen = [];
        $uniqueR = [];
        foreach ($responsibles as $r) {
            $key = $r['project_id'] . '-' . $r['user_id'];
            if (!isset($seen[$key])) {
                $seen[$key] = true;
                $uniqueR[] = $r;
            }
        }
        DB::table('crm_project_responsible')->insert($uniqueR);
    }
}
