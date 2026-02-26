<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class CrmDealSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        $pipelineIds = DB::table('crm_pipelines')->pluck('id')->toArray();
        $contactIds  = DB::table('crm_contacts')->pluck('id')->toArray();
        $userIds     = DB::table('users')->pluck('id')->toArray();
        $statuses    = ['New', 'In Progress', 'Won', 'Lost', 'On Hold'];
        $priorities  = ['Low', 'Medium', 'High', 'Urgent'];
        $sources     = ['Website', 'Referral', 'Social Media', 'Email Campaign', 'Cold Call', 'Trade Show'];
        $currencies  = ['USD', 'EUR', 'GBP'];
        $periods     = ['Daily', 'Weekly', 'Monthly', 'Quarterly', 'Yearly'];

        $deals = [];
        for ($i = 0; $i < 35; $i++) {
            $deals[] = [
                'deal_name'             => $faker->bs . ' Deal',
                'pipeline_id'           => $faker->randomElement($pipelineIds),
                'status'                => $faker->randomElement($statuses),
                'deal_value'            => $faker->randomFloat(2, 1000, 200000),
                'currency'              => $faker->randomElement($currencies),
                'period'                => $faker->optional(0.6)->randomElement($periods),
                'period_value'          => $faker->optional(0.5)->randomFloat(2, 100, 10000),
                'project'               => $faker->optional(0.4)->catchPhrase,
                'due_date'              => $faker->optional(0.7)->dateTimeBetween('now', '+1 year')?->format('Y-m-d'),
                'expected_closing_date' => $faker->optional(0.8)->dateTimeBetween('now', '+6 months')?->format('Y-m-d'),
                'follow_up_date'        => $faker->optional(0.5)->dateTimeBetween('now', '+3 months')?->format('Y-m-d'),
                'source'                => $faker->randomElement($sources),
                'tags'                  => implode(',', $faker->randomElements(['enterprise', 'smb', 'upsell', 'renewal', 'new'], $faker->numberBetween(1, 2))),
                'priority'              => $faker->randomElement($priorities),
                'description'           => $faker->optional(0.6)->paragraph,
                'created_at'            => $faker->dateTimeBetween('-1 year', 'now'),
                'updated_at'            => now(),
            ];
        }

        DB::table('crm_deals')->insert($deals);

        $dealIds = DB::table('crm_deals')->pluck('id')->toArray();

        // Assignees pivot
        $assignees = [];
        foreach ($dealIds as $dealId) {
            $assignees[] = ['deal_id' => $dealId, 'user_id' => $faker->randomElement($userIds)];
        }
        DB::table('crm_deal_assignee')->insert($assignees);

        // Contacts pivot
        $dealContacts = [];
        foreach ($dealIds as $dealId) {
            $picked = $faker->randomElements($contactIds, $faker->numberBetween(1, 3));
            foreach ($picked as $contactId) {
                $dealContacts[] = ['deal_id' => $dealId, 'contact_id' => $contactId];
            }
        }
        DB::table('crm_deal_contact')->insert($dealContacts);
    }
}
