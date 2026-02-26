<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class CrmContactSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        $companyIds  = DB::table('crm_companies')->pluck('id')->toArray();
        $industries  = ['Technology', 'Finance', 'Healthcare', 'Education', 'Manufacturing', 'Retail', 'Consulting'];
        $sources     = ['Website', 'Referral', 'Social Media', 'Email Campaign', 'Cold Call', 'Trade Show'];
        $currencies  = ['USD', 'EUR', 'GBP', 'AUD', 'CAD'];
        $languages   = ['English', 'Spanish', 'French', 'German', 'Portuguese'];
        $countries   = ['United States', 'United Kingdom', 'Canada', 'Australia', 'Germany', 'France'];
        $jobTitles   = ['CEO', 'CTO', 'CFO', 'Sales Manager', 'Marketing Director', 'Product Manager', 'Developer', 'Designer', 'HR Manager', 'Operations Manager', 'Account Executive', 'Business Analyst'];

        $contacts = [];
        for ($i = 0; $i < 40; $i++) {
            $contacts[] = [
                'profile_image' => null,
                'first_name'    => $faker->firstName,
                'last_name'     => $faker->lastName,
                'job_title'     => $faker->randomElement($jobTitles),
                'company_id'    => $faker->randomElement($companyIds),
                'email'         => $faker->unique()->safeEmail,
                'email_opt_out' => $faker->boolean(15),
                'phone_1'       => $faker->phoneNumber,
                'phone_2'       => $faker->optional(0.3)->phoneNumber,
                'fax'           => $faker->optional(0.1)->phoneNumber,
                'date_of_birth' => $faker->optional(0.6)->dateTimeBetween('-60 years', '-20 years')?->format('Y-m-d'),
                'reviews'       => $faker->randomElement(['1', '2', '3', '4', '5']),
                'owner_id'      => 1,
                'tags'          => implode(',', $faker->randomElements(['vip', 'prospect', 'customer', 'hot', 'cold', 'warm'], $faker->numberBetween(1, 3))),
                'source'        => $faker->randomElement($sources),
                'industry'      => $faker->randomElement($industries),
                'currency'      => $faker->randomElement($currencies),
                'language'      => $faker->randomElement($languages),
                'description'   => $faker->optional(0.7)->paragraph,
                'street_address'=> $faker->streetAddress,
                'country'       => $faker->randomElement($countries),
                'state'         => $faker->state,
                'city'          => $faker->city,
                'zipcode'       => $faker->postcode,
                'facebook'      => $faker->optional(0.5)->url,
                'skype'         => $faker->optional(0.3)->userName,
                'linkedin'      => $faker->optional(0.6)->url,
                'twitter'       => $faker->optional(0.4)->url,
                'whatsapp'      => $faker->optional(0.4)->phoneNumber,
                'instagram'     => $faker->optional(0.3)->url,
                'visibility'    => $faker->randomElement(['public', 'private']),
                'created_at'    => $faker->dateTimeBetween('-2 years', 'now'),
                'updated_at'    => now(),
            ];
        }

        DB::table('crm_contacts')->insert($contacts);
    }
}
