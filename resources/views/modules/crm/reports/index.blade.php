<x-layouts::app :title="__('CRM Reports')">
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        <div class="flex items-center justify-between">
            <flux:heading size="xl">CRM Reports & Analytics</flux:heading>
            <flux:badge variant="secondary">Last updated: {{ now()->format('M d, Y H:i') }}</flux:badge>
        </div>

        {{-- Summary KPI Cards --}}
        <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-6">
            @php
                $kpis = [
                    ['label' => 'Companies',  'value' => $stats['companies'],  'icon' => 'building-office-2', 'color' => 'blue',   'route' => 'crm.companies.index'],
                    ['label' => 'Contacts',   'value' => $stats['contacts'],   'icon' => 'users',              'color' => 'purple', 'route' => 'crm.contacts.index'],
                    ['label' => 'Leads',      'value' => $stats['leads'],      'icon' => 'funnel',             'color' => 'yellow', 'route' => 'crm.leads.index'],
                    ['label' => 'Deals',      'value' => $stats['deals'],      'icon' => 'currency-dollar',    'color' => 'green',  'route' => 'crm.deals.index'],
                    ['label' => 'Projects',   'value' => $stats['projects'],   'icon' => 'briefcase',          'color' => 'indigo', 'route' => 'crm.projects.index'],
                    ['label' => 'Tasks',      'value' => $stats['tasks'],      'icon' => 'check-badge',          'color' => 'teal',   'route' => 'crm.tasks.index'],
                ];
            @endphp
            @foreach($kpis as $kpi)
                <a href="{{ route($kpi['route']) }}" class="rounded-xl border border-neutral-200 bg-white p-4 transition hover:shadow-md dark:border-neutral-700 dark:bg-zinc-900">
                    <div class="text-2xl font-bold text-neutral-900 dark:text-white">{{ number_format($kpi['value']) }}</div>
                    <div class="mt-1 text-sm text-neutral-500">{{ $kpi['label'] }}</div>
                </a>
            @endforeach
        </div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            {{-- Leads by Type --}}
            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
                <flux:heading size="lg" class="mb-4">Leads by Type</flux:heading>
                @if(count($leadsByType))
                    <div class="space-y-2">
                        @php $totalLeads = array_sum(array_column($leadsByType->toArray(), 'total')); @endphp
                        @foreach($leadsByType as $row)
                            @php $pct = $totalLeads > 0 ? round(($row->total / $totalLeads) * 100) : 0; @endphp
                            <div class="flex items-center gap-3">
                                <div class="w-28 shrink-0 text-sm capitalize text-neutral-600 dark:text-neutral-400">{{ $row->lead_type ?? 'Unknown' }}</div>
                                <div class="flex-1 rounded-full bg-neutral-100 dark:bg-zinc-700" style="height:10px">
                                    <div class="h-full rounded-full bg-yellow-400" style="width: {{ $pct }}%"></div>
                                </div>
                                <div class="w-14 text-right text-sm font-medium">{{ $row->total }} <span class="text-xs text-neutral-400">({{ $pct }}%)</span></div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-neutral-400">No lead data available.</p>
                @endif
            </div>

            {{-- Leads by Source --}}
            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
                <flux:heading size="lg" class="mb-4">Leads by Source</flux:heading>
                @if(count($leadsBySource))
                    <div class="space-y-2">
                        @php $totalLeadSrc = array_sum(array_column($leadsBySource->toArray(), 'total')); @endphp
                        @foreach($leadsBySource as $row)
                            @php $pct = $totalLeadSrc > 0 ? round(($row->total / $totalLeadSrc) * 100) : 0; @endphp
                            <div class="flex items-center gap-3">
                                <div class="w-28 shrink-0 text-sm text-neutral-600 dark:text-neutral-400">{{ $row->source ?? 'Unknown' }}</div>
                                <div class="flex-1 rounded-full bg-neutral-100 dark:bg-zinc-700" style="height:10px">
                                    <div class="h-full rounded-full bg-orange-400" style="width: {{ $pct }}%"></div>
                                </div>
                                <div class="w-14 text-right text-sm font-medium">{{ $row->total }} <span class="text-xs text-neutral-400">({{ $pct }}%)</span></div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-neutral-400">No lead source data available.</p>
                @endif
            </div>

            {{-- Deals by Status --}}
            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
                <flux:heading size="lg" class="mb-4">Deals by Status</flux:heading>
                @if(count($dealsByStatus))
                    <div class="space-y-2">
                        @php $totalDeals = array_sum(array_column($dealsByStatus->toArray(), 'total')); @endphp
                        @foreach($dealsByStatus as $row)
                            @php
                                $pct = $totalDeals > 0 ? round(($row->total / $totalDeals) * 100) : 0;
                                $barColors = ['Won'=>'bg-green-500','Lost'=>'bg-red-400','New'=>'bg-blue-500','In Progress'=>'bg-yellow-400','On Hold'=>'bg-neutral-400'];
                            @endphp
                            <div class="flex items-center gap-3">
                                <div class="w-28 shrink-0 text-sm text-neutral-600 dark:text-neutral-400">{{ $row->status ?? 'Unknown' }}</div>
                                <div class="flex-1 rounded-full bg-neutral-100 dark:bg-zinc-700" style="height:10px">
                                    <div class="h-full rounded-full {{ $barColors[$row->status] ?? 'bg-blue-400' }}" style="width: {{ $pct }}%"></div>
                                </div>
                                <div class="w-14 text-right text-sm font-medium">{{ $row->total }} <span class="text-xs text-neutral-400">({{ $pct }}%)</span></div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-neutral-400">No deal data available.</p>
                @endif
            </div>

            {{-- Projects by Status --}}
            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
                <flux:heading size="lg" class="mb-4">Projects by Status</flux:heading>
                @if(count($projectsByStatus))
                    <div class="space-y-2">
                        @php $totalProjects = array_sum(array_column($projectsByStatus->toArray(), 'total')); @endphp
                        @foreach($projectsByStatus as $row)
                            @php
                                $pct = $totalProjects > 0 ? round(($row->total / $totalProjects) * 100) : 0;
                                $pc = ['Completed'=>'bg-green-500','In Progress'=>'bg-blue-500','Not Started'=>'bg-neutral-300','On Hold'=>'bg-yellow-400','Cancelled'=>'bg-red-400'];
                            @endphp
                            <div class="flex items-center gap-3">
                                <div class="w-32 shrink-0 text-sm text-neutral-600 dark:text-neutral-400">{{ $row->status ?? 'Unknown' }}</div>
                                <div class="flex-1 rounded-full bg-neutral-100 dark:bg-zinc-700" style="height:10px">
                                    <div class="h-full rounded-full {{ $pc[$row->status] ?? 'bg-indigo-400' }}" style="width: {{ $pct }}%"></div>
                                </div>
                                <div class="w-14 text-right text-sm font-medium">{{ $row->total }} <span class="text-xs text-neutral-400">({{ $pct }}%)</span></div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-neutral-400">No project data available.</p>
                @endif
            </div>

            {{-- Tasks by Status --}}
            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
                <flux:heading size="lg" class="mb-4">Tasks by Status</flux:heading>
                @if(count($tasksByStatus))
                    <div class="space-y-2">
                        @php $totalTasks = array_sum(array_column($tasksByStatus->toArray(), 'total')); @endphp
                        @foreach($tasksByStatus as $row)
                            @php
                                $pct = $totalTasks > 0 ? round(($row->total / $totalTasks) * 100) : 0;
                                $tc = ['Completed'=>'bg-green-500','In Progress'=>'bg-blue-500','Todo'=>'bg-neutral-300','Under Review'=>'bg-yellow-400'];
                            @endphp
                            <div class="flex items-center gap-3">
                                <div class="w-32 shrink-0 text-sm text-neutral-600 dark:text-neutral-400">{{ $row->status ?? 'Unknown' }}</div>
                                <div class="flex-1 rounded-full bg-neutral-100 dark:bg-zinc-700" style="height:10px">
                                    <div class="h-full rounded-full {{ $tc[$row->status] ?? 'bg-teal-400' }}" style="width: {{ $pct }}%"></div>
                                </div>
                                <div class="w-14 text-right text-sm font-medium">{{ $row->total }} <span class="text-xs text-neutral-400">({{ $pct }}%)</span></div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-neutral-400">No task data available.</p>
                @endif
            </div>
        </div>

        {{-- Deal Pipeline Value --}}
        <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
            <flux:heading size="lg" class="mb-4">Deal Value by Pipeline</flux:heading>
            @if(count($dealValueByPipeline))
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-neutral-100 dark:border-neutral-700">
                                <th class="pb-2 text-left font-medium text-neutral-500">Pipeline</th>
                                <th class="pb-2 text-right font-medium text-neutral-500">Deals</th>
                                <th class="pb-2 text-right font-medium text-neutral-500">Total Value</th>
                                <th class="pb-2 text-right font-medium text-neutral-500">Won Value</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-100 dark:divide-neutral-700">
                            @foreach($dealValueByPipeline as $row)
                                <tr>
                                    <td class="py-2">{{ $row->pipeline_name ?? 'No Pipeline' }}</td>
                                    <td class="py-2 text-right">{{ $row->deal_count }}</td>
                                    <td class="py-2 text-right font-medium">{{ number_format($row->total_value ?? 0, 2) }}</td>
                                    <td class="py-2 text-right text-green-600 font-medium">{{ number_format($row->won_value ?? 0, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-sm text-neutral-400">No pipeline deal data available.</p>
            @endif
        </div>

        {{-- Contact & Company Summary --}}
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
                <flux:heading size="lg" class="mb-4">Contacts by Source</flux:heading>
                @if(count($contactsBySource))
                    <div class="space-y-2">
                        @foreach($contactsBySource as $row)
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-neutral-600 dark:text-neutral-400">{{ $row->source ?? 'Unknown' }}</span>
                                <span class="font-medium">{{ $row->total }}</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-neutral-400">No contact source data available.</p>
                @endif
            </div>

            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
                <flux:heading size="lg" class="mb-4">Companies by Industry</flux:heading>
                @if(count($companiesByIndustry))
                    <div class="space-y-2">
                        @foreach($companiesByIndustry as $row)
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-neutral-600 dark:text-neutral-400">{{ $row->industry ?? 'Unknown' }}</span>
                                <span class="font-medium">{{ $row->total }}</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-neutral-400">No company industry data available.</p>
                @endif
            </div>
        </div>

        {{-- Invoice Summary --}}
        <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
            <flux:heading size="lg" class="mb-4">Invoice Summary</flux:heading>
            <div class="grid grid-cols-2 gap-4 sm:grid-cols-4">
                @php
                    $invColors = ['Draft'=>'bg-neutral-100 text-neutral-600','Sent'=>'bg-blue-50 text-blue-700','Paid'=>'bg-green-50 text-green-700','Overdue'=>'bg-red-50 text-red-700','Cancelled'=>'bg-zinc-100 text-zinc-600'];
                @endphp
                @foreach($invoicesByStatus as $row)
                    <div class="rounded-lg p-4 {{ $invColors[$row->status] ?? 'bg-neutral-50 text-neutral-700' }}">
                        <div class="text-2xl font-bold">{{ $row->total }}</div>
                        <div class="text-sm">{{ $row->status ?? 'Unknown' }}</div>
                        <div class="mt-1 text-xs opacity-75">{{ number_format($row->total_amount ?? 0, 2) }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-layouts::app>
