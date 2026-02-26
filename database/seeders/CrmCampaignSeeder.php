<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class CrmCampaignSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        $types     = ['Email', 'SMS', 'Social Media', 'Display Ads', 'Content', 'Referral', 'Event', 'Other'];
        $currencies = ['USD', 'EUR', 'GBP'];
        $periods   = ['Daily', 'Weekly', 'Monthly', 'Quarterly', 'Yearly'];
        $audiences = ['All Contacts', 'VIP Customers', 'Prospects', 'Enterprise Clients', 'SMB Clients', 'Inactive Leads', 'Newsletter Subscribers'];

        $campaigns = [];
        for ($i = 0; $i < 15; $i++) {
            $campaigns[] = [
                'name'            => $faker->catchPhrase . ' Campaign',
                'campaign_type'   => $faker->randomElement($types),
                'deal_value'      => $faker->optional(0.7)->randomFloat(2, 500, 50000),
                'currency'        => $faker->randomElement($currencies),
                'period'          => $faker->randomElement($periods),
                'period_value'    => $faker->optional(0.6)->randomFloat(2, 100, 5000),
                'target_audience' => $faker->randomElement($audiences),
                'description'     => $faker->optional(0.7)->paragraph,
                'attachment'      => null,
                'created_at'      => $faker->dateTimeBetween('-1 year', 'now'),
                'updated_at'      => now(),
            ];
        }

        DB::table('crm_campaigns')->insert($campaigns);
    }
}
