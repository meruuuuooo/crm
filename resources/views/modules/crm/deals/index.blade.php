<x-layouts::app :title="__('Deals')">
    <div class="flex h-full w-full flex-1 flex-col gap-4">
        <div class="flex items-center justify-between">
            <flux:heading size="xl">Deals</flux:heading>
            <div class="flex gap-2">
                <flux:button href="{{ route('crm.pipelines.index') }}" variant="ghost" icon="arrows-right-left" wire:navigate>Pipelines</flux:button>
                <flux:button href="{{ route('crm.deals.create') }}" variant="primary" icon="plus" wire:navigate>Add Deal</flux:button>
            </div>
        </div>

        @include('modules.crm.partials.flash')

        <div class="overflow-hidden rounded-xl border border-neutral-200 bg-white dark:border-neutral-700 dark:bg-zinc-900">
            <table class="w-full text-sm">
                <thead class="bg-neutral-50 dark:bg-zinc-800">
                    <tr>
                        <th class="px-4 py-3 text-left font-medium text-neutral-600 dark:text-neutral-300">Deal Name</th>
                        <th class="px-4 py-3 text-left font-medium text-neutral-600 dark:text-neutral-300">Pipeline</th>
                        <th class="px-4 py-3 text-left font-medium text-neutral-600 dark:text-neutral-300">Value</th>
                        <th class="px-4 py-3 text-left font-medium text-neutral-600 dark:text-neutral-300">Status</th>
                        <th class="px-4 py-3 text-left font-medium text-neutral-600 dark:text-neutral-300">Priority</th>
                        <th class="px-4 py-3 text-left font-medium text-neutral-600 dark:text-neutral-300">Closing Date</th>
                        <th class="px-4 py-3 text-right font-medium text-neutral-600 dark:text-neutral-300">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-100 dark:divide-neutral-700">
                    @forelse ($deals as $deal)
                        <tr class="hover:bg-neutral-50 dark:hover:bg-zinc-800/50">
                            <td class="px-4 py-3 font-medium">
                                <a href="{{ route('crm.deals.show', $deal) }}" class="text-blue-600 hover:underline">{{ $deal->deal_name }}</a>
                            </td>
                            <td class="px-4 py-3 text-neutral-600 dark:text-neutral-400">{{ $deal->pipeline?->name ?? '—' }}</td>
                            <td class="px-4 py-3 text-neutral-600 dark:text-neutral-400">
                                {{ $deal->currency }} {{ number_format($deal->deal_value ?? 0, 2) }}
                            </td>
                            <td class="px-4 py-3">
                                @php
                                    $statusColors = ['Won'=>'success','Lost'=>'danger','New'=>'primary','In Progress'=>'warning','On Hold'=>'secondary'];
                                @endphp
                                <flux:badge variant="{{ $statusColors[$deal->status] ?? 'secondary' }}" size="sm">{{ $deal->status ?? '—' }}</flux:badge>
                            </td>
                            <td class="px-4 py-3">
                                @php $pc = ['High'=>'danger','Urgent'=>'danger','Medium'=>'warning','Low'=>'success']; @endphp
                                <flux:badge variant="{{ $pc[$deal->priority] ?? 'secondary' }}" size="sm">{{ $deal->priority ?? '—' }}</flux:badge>
                            </td>
                            <td class="px-4 py-3 text-neutral-600 dark:text-neutral-400">{{ $deal->expected_closing_date?->format('M d, Y') ?? '—' }}</td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex justify-end gap-2">
                                    <flux:button href="{{ route('crm.deals.edit', $deal) }}" size="sm" variant="ghost" icon="pencil" wire:navigate />
                                    <form method="POST" action="{{ route('crm.deals.destroy', $deal) }}" onsubmit="return confirm('Delete this deal?')">
                                        @csrf @method('DELETE')
                                        <flux:button type="submit" size="sm" variant="ghost" icon="trash" class="text-red-500" />
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-neutral-400">No deals found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div>{{ $deals->links() }}</div>
    </div>
</x-layouts::app>
