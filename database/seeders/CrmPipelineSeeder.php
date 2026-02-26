<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CrmPipelineSeeder extends Seeder
{
    public function run(): void
    {
        $pipelines = [
            [
                'name'             => 'Sales Pipeline',
                'access_type'      => 'public',
                'stages'           => json_encode(['Lead', 'Qualified', 'Proposal', 'Negotiation', 'Closed Won', 'Closed Lost']),
                'selected_persons' => json_encode([]),
                'created_at'       => now(),
                'updated_at'       => now(),
            ],
            [
                'name'             => 'Enterprise Pipeline',
                'access_type'      => 'public',
                'stages'           => json_encode(['Prospecting', 'Discovery', 'Demo', 'POC', 'Contract', 'Won', 'Lost']),
                'selected_persons' => json_encode([]),
                'created_at'       => now(),
                'updated_at'       => now(),
            ],
            [
                'name'             => 'Partner Pipeline',
                'access_type'      => 'private',
                'stages'           => json_encode(['Identified', 'Engaged', 'Agreement', 'Active', 'Inactive']),
                'selected_persons' => json_encode([]),
                'created_at'       => now(),
                'updated_at'       => now(),
            ],
        ];

        DB::table('crm_pipelines')->insert($pipelines);
    }
}
