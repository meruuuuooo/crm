<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class CrmContractSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        $clientIds     = DB::table('crm_contacts')->pluck('id')->toArray();
        $contractTypes = ['Service Agreement', 'NDA', 'Partnership', 'Employment', 'Vendor', 'Other'];
        $currencies    = ['USD', 'EUR', 'GBP'];

        $contracts = [];
        for ($i = 0; $i < 15; $i++) {
            $start = $faker->dateTimeBetween('-2 years', 'now');
            $contracts[] = [
                'subject'        => $faker->catchPhrase . ' Contract',
                'start_date'     => $start->format('Y-m-d'),
                'end_date'       => $faker->dateTimeBetween($start, '+2 years')->format('Y-m-d'),
                'client_id'      => $faker->optional(0.8)->randomElement($clientIds),
                'contract_type'  => $faker->randomElement($contractTypes),
                'contract_value' => $faker->randomFloat(2, 5000, 500000),
                'attachment'     => null,
                'description'    => $faker->optional(0.6)->paragraph,
                'created_at'     => $faker->dateTimeBetween('-2 years', 'now'),
                'updated_at'     => now(),
            ];
        }

        DB::table('crm_contracts')->insert($contracts);
    }
}
