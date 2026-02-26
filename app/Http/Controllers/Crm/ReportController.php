<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use App\Models\Crm\Lead;
use App\Models\Crm\Deal;
use App\Models\Crm\Contact;
use App\Models\Crm\Company;
use App\Models\Crm\Project;
use App\Models\Crm\Task;
use App\Models\Crm\Invoice;
use App\Models\Crm\Pipeline;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        $stats = [
            'companies' => Company::count(),
            'contacts'  => Contact::count(),
            'leads'     => Lead::count(),
            'deals'     => Deal::count(),
            'projects'  => Project::count(),
            'tasks'     => Task::count(),
        ];

        $leadsByType = Lead::selectRaw('lead_type, count(*) as total')
            ->groupBy('lead_type')->orderByDesc('total')->get();

        $leadsBySource = Lead::selectRaw('source, count(*) as total')
            ->whereNotNull('source')
            ->groupBy('source')->orderByDesc('total')->get();

        $dealsByStatus = Deal::selectRaw('status, count(*) as total')
            ->groupBy('status')->orderByDesc('total')->get();

        $projectsByStatus = Project::selectRaw('status, count(*) as total')
            ->groupBy('status')->orderByDesc('total')->get();

        $tasksByStatus = Task::selectRaw('status, count(*) as total')
            ->groupBy('status')->orderByDesc('total')->get();

        $dealValueByPipeline = DB::table('crm_deals')
            ->leftJoin('crm_pipelines', 'crm_deals.pipeline_id', '=', 'crm_pipelines.id')
            ->selectRaw('crm_pipelines.name as pipeline_name, count(crm_deals.id) as deal_count, sum(crm_deals.deal_value) as total_value, sum(case when crm_deals.status = \'Won\' then crm_deals.deal_value else 0 end) as won_value')
            ->groupBy('crm_pipelines.id', 'crm_pipelines.name')
            ->get();

        $contactsBySource = Contact::selectRaw('source, count(*) as total')
            ->whereNotNull('source')
            ->groupBy('source')->orderByDesc('total')->get();

        $companiesByIndustry = Company::selectRaw('industry, count(*) as total')
            ->whereNotNull('industry')
            ->groupBy('industry')->orderByDesc('total')->get();

        $invoicesByStatus = Invoice::selectRaw('status, count(*) as total, sum(amount) as total_amount')
            ->groupBy('status')->orderByDesc('total')->get();

        return view('modules.crm.reports.index', compact(
            'stats',
            'leadsByType',
            'leadsBySource',
            'dealsByStatus',
            'projectsByStatus',
            'tasksByStatus',
            'dealValueByPipeline',
            'contactsBySource',
            'companiesByIndustry',
            'invoicesByStatus'
        ));
    }
}
