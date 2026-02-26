<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class CrmInvoiceSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        $clientIds  = DB::table('crm_contacts')->pluck('id')->toArray();
        $projectIds = DB::table('crm_projects')->pluck('id')->toArray();
        $statuses   = ['Draft', 'Sent', 'Paid', 'Overdue', 'Cancelled'];
        $currencies = ['USD', 'EUR', 'GBP'];
        $payments   = ['Bank Transfer', 'Credit Card', 'PayPal', 'Stripe', 'Cheque'];

        $invoices = [];
        for ($i = 0; $i < 25; $i++) {
            $date = $faker->dateTimeBetween('-1 year', 'now');
            $lineItems = [];
            $total = 0;
            for ($j = 0; $j < $faker->numberBetween(1, 5); $j++) {
                $qty   = $faker->numberBetween(1, 20);
                $rate  = round($faker->randomFloat(2, 50, 2000), 2);
                $lineItems[] = [
                    'description' => $faker->sentence(3),
                    'quantity'    => $qty,
                    'rate'        => $rate,
                    'amount'      => $qty * $rate,
                ];
                $total += $qty * $rate;
            }

            $invoices[] = [
                'client_id'        => $faker->optional(0.8)->randomElement($clientIds),
                'bill_to'          => $faker->address,
                'ship_to'          => $faker->optional(0.5)->address,
                'project_id'       => $faker->optional(0.6)->randomElement($projectIds),
                'amount'           => round($total, 2),
                'currency'         => $faker->randomElement($currencies),
                'date'             => $date->format('Y-m-d'),
                'open_till'        => $faker->dateTimeBetween($date, '+60 days')->format('Y-m-d'),
                'payment_method'   => $faker->randomElement($payments),
                'status'           => $faker->randomElement($statuses),
                'description'      => $faker->optional(0.5)->paragraph,
                'line_items'       => json_encode($lineItems),
                'notes'            => $faker->optional(0.4)->sentence,
                'terms_conditions' => $faker->optional(0.4)->sentence,
                'created_at'       => $date,
                'updated_at'       => now(),
            ];
        }

        DB::table('crm_invoices')->insert($invoices);
    }
}
