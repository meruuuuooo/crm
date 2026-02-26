<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class CrmProposalSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        $clientIds  = DB::table('crm_contacts')->pluck('id')->toArray();
        $projectIds = DB::table('crm_projects')->pluck('id')->toArray();
        $dealIds    = DB::table('crm_deals')->pluck('id')->toArray();
        $userIds    = DB::table('users')->pluck('id')->toArray();
        $statuses   = ['Draft', 'Sent', 'Accepted', 'Declined', 'Expired'];
        $currencies = ['USD', 'EUR', 'GBP'];
        $relatedTo  = ['Deal', 'Project', 'Contact'];

        $proposals = [];
        for ($i = 0; $i < 20; $i++) {
            $date = $faker->dateTimeBetween('-1 year', 'now');
            $proposals[] = [
                'subject'    => $faker->sentence(5),
                'date'       => $date->format('Y-m-d'),
                'open_till'  => $faker->dateTimeBetween($date, '+30 days')->format('Y-m-d'),
                'client_id'  => $faker->optional(0.8)->randomElement($clientIds),
                'project_id' => $faker->optional(0.5)->randomElement($projectIds),
                'related_to' => $faker->randomElement($relatedTo),
                'deal_id'    => $faker->optional(0.6)->randomElement($dealIds),
                'currency'   => $faker->randomElement($currencies),
                'status'     => $faker->randomElement($statuses),
                'attachment' => null,
                'tags'       => implode(',', $faker->randomElements(['urgent', 'follow-up', 'enterprise', 'smb'], $faker->numberBetween(1, 2))),
                'description'=> $faker->optional(0.6)->paragraph,
                'created_at' => $date,
                'updated_at' => now(),
            ];
        }

        DB::table('crm_proposals')->insert($proposals);

        $proposalIds = DB::table('crm_proposals')->pluck('id')->toArray();
        $assignees = [];
        foreach ($proposalIds as $proposalId) {
            $assignees[] = ['proposal_id' => $proposalId, 'user_id' => $faker->randomElement($userIds)];
        }
        DB::table('crm_proposal_assignee')->insert($assignees);
    }
}
