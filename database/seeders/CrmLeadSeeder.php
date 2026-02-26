<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class CrmLeadSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        $companyIds  = DB::table('crm_companies')->pluck('id')->toArray();
        $userIds     = DB::table('users')->pluck('id')->toArray();
        $sources     = ['Website', 'Referral', 'Social Media', 'Email Campaign', 'Cold Call', 'Trade Show', 'Advertisement', 'Partner'];
        $industries  = ['Technology', 'Finance', 'Healthcare', 'Education', 'Manufacturing', 'Retail', 'Consulting'];
        $currencies  = ['USD', 'EUR', 'GBP', 'AUD'];
        $phoneTypes  = ['Mobile', 'Work', 'Home', 'Fax'];
        $leadTypes   = ['individual', 'company'];
        $visibilities = ['public', 'private'];

        $leads = [];
        for ($i = 0; $i < 30; $i++) {
            $leads[] = [
                'lead_name'   => $faker->name,
                'lead_type'   => $faker->randomElement($leadTypes),
                'company_id'  => $faker->optional(0.7)->randomElement($companyIds),
                'value'       => $faker->optional(0.8)->randomFloat(2, 500, 50000),
                'currency'    => $faker->randomElement($currencies),
                'phone'       => $faker->phoneNumber,
                'phone_type'  => $faker->randomElement($phoneTypes),
                'source'      => $faker->randomElement($sources),
                'industry'    => $faker->randomElement($industries),
                'tags'        => implode(',', $faker->randomElements(['hot', 'warm', 'cold', 'vip', 'new'], $faker->numberBetween(1, 3))),
                'description' => $faker->optional(0.6)->paragraph,
                'visibility'  => $faker->randomElement($visibilities),
                'created_at'  => $faker->dateTimeBetween('-1 year', 'now'),
                'updated_at'  => now(),
            ];
        }

        DB::table('crm_leads')->insert($leads);

        // Assign owners (lead_owner pivot)
        $leadIds = DB::table('crm_leads')->pluck('id')->toArray();
        $pivots = [];
        foreach ($leadIds as $leadId) {
            $pivots[] = [
                'lead_id' => $leadId,
                'user_id' => $faker->randomElement($userIds),
            ];
        }
        DB::table('crm_lead_owner')->insert($pivots);
    }
}
