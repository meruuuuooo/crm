<x-layouts::app :title="$pipeline->name">
    <div class="flex h-full w-full flex-1 flex-col gap-4">
        {{-- Header --}}
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <flux:button href="{{ route('crm.pipelines.index') }}" variant="ghost" icon="arrow-left" size="sm" wire:navigate />
                <div>
                    <flux:heading size="xl">{{ $pipeline->name }}</flux:heading>
                    <div class="mt-0.5 flex items-center gap-2">
                        <flux:badge variant="{{ $pipeline->access_type === 'public' ? 'success' : 'secondary' }}" size="sm">
                            {{ ucfirst($pipeline->access_type ?? 'private') }}
                        </flux:badge>
                        <span class="text-sm text-neutral-500">{{ $pipeline->deals->count() }} deal(s)</span>
                    </div>
                </div>
            </div>
            <div class="flex gap-2">
                <flux:button href="{{ route('crm.pipelines.edit', $pipeline) }}" variant="outline" icon="pencil" size="sm" wire:navigate>Edit</flux:button>
                <form method="POST" action="{{ route('crm.pipelines.destroy', $pipeline) }}" onsubmit="return confirm('Delete this pipeline?')">
                    @csrf @method('DELETE')
                    <flux:button type="submit" variant="danger" icon="trash" size="sm">Delete</flux:button>
                </form>
            </div>
        </div>

        @include('modules.crm.partials.flash')

        {{-- Stages Kanban --}}
        @if($pipeline->stages && count($pipeline->stages))
            <div class="overflow-x-auto">
                <div class="flex min-w-max gap-4 pb-4">
                    @foreach($pipeline->stages as $stage)
                        @php
                            $stageDeals = $pipeline->deals->where('status', $stage);
                            $stageValue = $stageDeals->sum('deal_value');
                        @endphp
                        <div class="w-72 shrink-0">
                            {{-- Stage Header --}}
                            <div class="mb-3 flex items-center justify-between rounded-lg bg-neutral-100 px-3 py-2 dark:bg-zinc-800">
                                <div class="flex items-center gap-2">
                                    <span class="font-semibold text-sm text-neutral-700 dark:text-neutral-200">{{ $stage }}</span>
                                    <flux:badge size="sm">{{ $stageDeals->count() }}</flux:badge>
                                </div>
                                @if($stageValue > 0)
                                    <span class="text-xs font-medium text-green-600 dark:text-green-400">
                                        {{ number_format($stageValue, 0) }}
                                    </span>
                                @endif
                            </div>

                            {{-- Deal Cards --}}
                            <div class="space-y-2">
                                @forelse($stageDeals as $deal)
                                    <a href="{{ route('crm.deals.show', $deal) }}" class="block rounded-xl border border-neutral-200 bg-white p-4 shadow-sm transition hover:border-blue-300 hover:shadow-md dark:border-neutral-700 dark:bg-zinc-900 dark:hover:border-blue-600" wire:navigate>
                                        <p class="font-medium text-sm text-neutral-900 dark:text-white">{{ $deal->deal_name }}</p>
                                        @if($deal->deal_value)
                                            <p class="mt-1 text-sm font-semibold text-green-600 dark:text-green-400">
                                                {{ $deal->currency ?? '' }} {{ number_format($deal->deal_value, 2) }}
                                            </p>
                                        @endif
                                        @if($deal->priority)
                                            <div class="mt-2">
                                                <flux:badge size="sm" variant="{{ match($deal->priority) { 'high' => 'danger', 'medium' => 'warning', default => 'secondary' } }}">
                                                    {{ ucfirst($deal->priority) }}
                                                </flux:badge>
                                            </div>
                                        @endif
                                        @if($deal->expected_closing_date)
                                            <p class="mt-2 flex items-center gap-1 text-xs text-neutral-400">
                                                <flux:icon name="calendar" class="size-3.5" />
                                                {{ $deal->expected_closing_date->format('M d, Y') }}
                                            </p>
                                        @endif
                                    </a>
                                @empty
                                    <div class="rounded-xl border-2 border-dashed border-neutral-200 px-4 py-6 text-center dark:border-neutral-700">
                                        <p class="text-xs text-neutral-400">No deals in this stage</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    @endforeach

                    {{-- Unassigned Deals --}}
                    @php
                        $unassignedDeals = $pipeline->deals->whereNotIn('status', $pipeline->stages);
                    @endphp
                    @if($unassignedDeals->count())
                        <div class="w-72 shrink-0">
                            <div class="mb-3 flex items-center justify-between rounded-lg bg-neutral-100 px-3 py-2 dark:bg-zinc-800">
                                <div class="flex items-center gap-2">
                                    <span class="font-semibold text-sm text-neutral-500">Unassigned</span>
                                    <flux:badge size="sm" variant="secondary">{{ $unassignedDeals->count() }}</flux:badge>
                                </div>
                            </div>
                            <div class="space-y-2">
                                @foreach($unassignedDeals as $deal)
                                    <a href="{{ route('crm.deals.show', $deal) }}" class="block rounded-xl border border-neutral-200 bg-white p-4 shadow-sm transition hover:border-blue-300 hover:shadow-md dark:border-neutral-700 dark:bg-zinc-900" wire:navigate>
                                        <p class="font-medium text-sm text-neutral-900 dark:text-white">{{ $deal->deal_name }}</p>
                                        @if($deal->deal_value)
                                            <p class="mt-1 text-sm font-semibold text-green-600 dark:text-green-400">
                                                {{ $deal->currency ?? '' }} {{ number_format($deal->deal_value, 2) }}
                                            </p>
                                        @endif
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @else
            {{-- No stages – show flat deal list --}}
            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
                <flux:heading size="lg" class="mb-4">Deals</flux:heading>
                @forelse($pipeline->deals as $deal)
                    <div class="flex items-center justify-between border-b border-neutral-100 py-3 last:border-0 dark:border-neutral-700">
                        <div>
                            <a href="{{ route('crm.deals.show', $deal) }}" class="font-medium text-neutral-900 hover:text-blue-600 dark:text-white" wire:navigate>{{ $deal->deal_name }}</a>
                            @if($deal->status)
                                <span class="ml-2 text-xs text-neutral-400">{{ $deal->status }}</span>
                            @endif
                        </div>
                        @if($deal->deal_value)
                            <span class="text-sm font-semibold text-green-600 dark:text-green-400">
                                {{ $deal->currency ?? '' }} {{ number_format($deal->deal_value, 2) }}
                            </span>
                        @endif
                    </div>
                @empty
                    <p class="text-center text-neutral-400 py-8">No deals assigned to this pipeline.</p>
                @endforelse
            </div>

            {{-- Pipeline has no stages; prompt to add some --}}
            <div class="rounded-xl border-2 border-dashed border-neutral-200 p-8 text-center dark:border-neutral-700">
                <flux:icon name="arrows-right-left" class="mx-auto mb-3 size-10 text-neutral-300 dark:text-neutral-600" />
                <p class="text-neutral-500">This pipeline has no stages defined.</p>
                <div class="mt-4">
                    <flux:button href="{{ route('crm.pipelines.edit', $pipeline) }}" variant="primary" size="sm" icon="pencil" wire:navigate>Add Stages</flux:button>
                </div>
            </div>
        @endif

        {{-- Summary Stats --}}
        <div class="mt-2 grid grid-cols-2 gap-4 md:grid-cols-4">
            <div class="rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-zinc-900">
                <p class="text-xs font-medium uppercase tracking-wide text-neutral-400">Total Deals</p>
                <p class="mt-1 text-2xl font-bold text-neutral-900 dark:text-white">{{ $pipeline->deals->count() }}</p>
            </div>
            <div class="rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-zinc-900">
                <p class="text-xs font-medium uppercase tracking-wide text-neutral-400">Total Value</p>
                <p class="mt-1 text-2xl font-bold text-green-600 dark:text-green-400">{{ number_format($pipeline->deals->sum('deal_value'), 0) }}</p>
            </div>
            <div class="rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-zinc-900">
                <p class="text-xs font-medium uppercase tracking-wide text-neutral-400">Stages</p>
                <p class="mt-1 text-2xl font-bold text-neutral-900 dark:text-white">{{ count($pipeline->stages ?? []) }}</p>
            </div>
            <div class="rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-zinc-900">
                <p class="text-xs font-medium uppercase tracking-wide text-neutral-400">Access</p>
                <p class="mt-1 text-lg font-bold text-neutral-900 dark:text-white">{{ ucfirst($pipeline->access_type ?? 'private') }}</p>
            </div>
        </div>
    </div>
</x-layouts::app>
