<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class CrmEstimationSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        $clientIds  = DB::table('crm_contacts')->pluck('id')->toArray();
        $projectIds = DB::table('crm_projects')->pluck('id')->toArray();
        $statuses   = ['Draft', 'Sent', 'Approved', 'Declined', 'Expired'];
        $currencies = ['USD', 'EUR', 'GBP'];

        $estimations = [];
        for ($i = 0; $i < 20; $i++) {
            $date = $faker->dateTimeBetween('-1 year', 'now');
            $amount = $faker->randomFloat(2, 1000, 100000);
            $estimations[] = [
                'client_id'     => $faker->optional(0.8)->randomElement($clientIds),
                'bill_to'       => $faker->address,
                'ship_to'       => $faker->optional(0.4)->address,
                'project_id'    => $faker->optional(0.6)->randomElement($projectIds),
                'estimate_by'   => $faker->name,
                'amount'        => $amount,
                'currency'      => $faker->randomElement($currencies),
                'estimate_date' => $date->format('Y-m-d'),
                'expiry_date'   => $faker->dateTimeBetween($date, '+30 days')->format('Y-m-d'),
                'status'        => $faker->randomElement($statuses),
                'tags'          => implode(',', $faker->randomElements(['high-value', 'pending', 'rush', 'approved'], $faker->numberBetween(1, 2))),
                'attachment'    => null,
                'description'   => $faker->optional(0.6)->paragraph,
                'created_at'    => $date,
                'updated_at'    => now(),
            ];
        }

        DB::table('crm_estimations')->insert($estimations);
    }
}
