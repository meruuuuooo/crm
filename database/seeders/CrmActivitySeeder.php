<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class CrmActivitySeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        $userIds    = DB::table('users')->pluck('id')->toArray();
        $dealIds    = DB::table('crm_deals')->pluck('id')->toArray();
        $contactIds = DB::table('crm_contacts')->pluck('id')->toArray();
        $companyIds = DB::table('crm_companies')->pluck('id')->toArray();
        $types      = ['Call', 'Meeting', 'Email', 'Task', 'Follow Up', 'Demo', 'Other'];
        $reminderUnits = ['minutes', 'hours', 'days'];

        $activities = [];
        for ($i = 0; $i < 30; $i++) {
            $activities[] = [
                'title'          => $faker->sentence(4),
                'activity_type'  => $faker->randomElement($types),
                'due_date'       => $faker->dateTimeBetween('now', '+3 months')->format('Y-m-d'),
                'time'           => $faker->time('H:i:s'),
                'reminder_value' => $faker->numberBetween(5, 60),
                'reminder_unit'  => $faker->randomElement($reminderUnits),
                'owner_id'       => $faker->randomElement($userIds),
                'description'    => $faker->optional(0.6)->paragraph,
                'deal_id'        => $faker->optional(0.6)->randomElement($dealIds),
                'contact_id'     => $faker->optional(0.7)->randomElement($contactIds),
                'company_id'     => $faker->optional(0.5)->randomElement($companyIds),
                'created_at'     => $faker->dateTimeBetween('-6 months', 'now'),
                'updated_at'     => now(),
            ];
        }

        DB::table('crm_activities')->insert($activities);

        $activityIds = DB::table('crm_activities')->pluck('id')->toArray();
        $guests = [];
        foreach ($activityIds as $actId) {
            if ($faker->boolean(60)) {
                $guests[] = ['activity_id' => $actId, 'user_id' => $faker->randomElement($userIds)];
            }
        }
        if (!empty($guests)) {
            // De-duplicate
            $seen = [];
            $unique = [];
            foreach ($guests as $g) {
                $key = $g['activity_id'] . '-' . $g['user_id'];
                if (!isset($seen[$key])) {
                    $seen[$key] = true;
                    $unique[] = $g;
                }
            }
            DB::table('crm_activity_guest')->insert($unique);
        }
    }
}
