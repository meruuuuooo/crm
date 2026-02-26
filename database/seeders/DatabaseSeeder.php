<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            ['name'  => 'Test User', 'password' => bcrypt('password')],
        );

        $this->call([
            CrmPipelineSeeder::class,  // no deps
            CrmCompanySeeder::class,   // no deps
            CrmContactSeeder::class,   // depends on companies
            CrmLeadSeeder::class,      // depends on companies
            CrmDealSeeder::class,      // depends on pipelines, contacts
            CrmProjectSeeder::class,   // depends on contacts
            CrmTaskSeeder::class,      // no deps
            CrmActivitySeeder::class,  // depends on deals, contacts, companies
            CrmContractSeeder::class,  // depends on contacts
            CrmEstimationSeeder::class,// depends on contacts, projects
            CrmInvoiceSeeder::class,   // depends on contacts, projects
            CrmProposalSeeder::class,  // depends on contacts, projects, deals
            CrmCampaignSeeder::class,  // no deps
        ]);
    }
}
