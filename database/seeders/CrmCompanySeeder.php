<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class CrmCompanySeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        $industries  = ['Technology', 'Finance', 'Healthcare', 'Education', 'Manufacturing', 'Retail', 'Real Estate', 'Media', 'Legal', 'Consulting'];
        $sources     = ['Website', 'Referral', 'Social Media', 'Email Campaign', 'Cold Call', 'Trade Show', 'Advertisement', 'Partner'];
        $currencies  = ['USD', 'EUR', 'GBP', 'AUD', 'CAD'];
        $languages   = ['English', 'Spanish', 'French', 'German', 'Portuguese'];
        $countries   = ['United States', 'United Kingdom', 'Canada', 'Australia', 'Germany', 'France', 'Spain'];
        $visibilities = ['public', 'private'];

        $companies = [];
        for ($i = 0; $i < 20; $i++) {
            $companies[] = [
                'company_name'  => $faker->company,
                'email'         => $faker->companyEmail,
                'email_opt_out' => $faker->boolean(20),
                'phone_1'       => $faker->phoneNumber,
                'phone_2'       => $faker->optional(0.4)->phoneNumber,
                'fax'           => $faker->optional(0.2)->phoneNumber,
                'website'       => $faker->url,
                'reviews'       => $faker->randomElement(['1', '2', '3', '4', '5']),
                'owner_id'      => 1,
                'tags'          => implode(',', $faker->randomElements(['vip', 'prospect', 'partner', 'enterprise', 'startup', 'hot'], $faker->numberBetween(1, 3))),
                'source'        => $faker->randomElement($sources),
                'industry'      => $faker->randomElement($industries),
                'currency'      => $faker->randomElement($currencies),
                'language'      => $faker->randomElement($languages),
                'description'   => $faker->paragraph,
                'street_address'=> $faker->streetAddress,
                'country'       => $faker->randomElement($countries),
                'state'         => $faker->state,
                'city'          => $faker->city,
                'zipcode'       => $faker->postcode,
                'facebook'      => 'https://facebook.com/' . $faker->slug,
                'linkedin'      => 'https://linkedin.com/company/' . $faker->slug,
                'twitter'       => 'https://twitter.com/' . $faker->slug,
                'whatsapp'      => $faker->optional(0.5)->phoneNumber,
                'instagram'     => $faker->optional(0.5)->url,
                'skype'         => $faker->optional(0.3)->userName,
                'visibility'    => $faker->randomElement($visibilities),
                'company_files' => null,
                'created_at'    => $faker->dateTimeBetween('-2 years', 'now'),
                'updated_at'    => now(),
            ];
        }

        DB::table('crm_companies')->insert($companies);
    }
}
