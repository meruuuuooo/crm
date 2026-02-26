<x-layouts::app :title="__('Contracts')">
    <div class="flex h-full w-full flex-1 flex-col gap-4">
        <div class="flex items-center justify-between">
            <flux:heading size="xl">Contracts</flux:heading>
            <flux:button href="{{ route('crm.contracts.create') }}" variant="primary" icon="plus" wire:navigate>Add Contract</flux:button>
        </div>

        @include('modules.crm.partials.flash')

        <div class="overflow-hidden rounded-xl border border-neutral-200 bg-white dark:border-neutral-700 dark:bg-zinc-900">
            <table class="w-full text-sm">
                <thead class="bg-neutral-50 dark:bg-zinc-800">
                    <tr>
                        <th class="px-4 py-3 text-left font-medium text-neutral-600 dark:text-neutral-300">Subject</th>
                        <th class="px-4 py-3 text-left font-medium text-neutral-600 dark:text-neutral-300">Client</th>
                        <th class="px-4 py-3 text-left font-medium text-neutral-600 dark:text-neutral-300">Type</th>
                        <th class="px-4 py-3 text-left font-medium text-neutral-600 dark:text-neutral-300">Value</th>
                        <th class="px-4 py-3 text-left font-medium text-neutral-600 dark:text-neutral-300">Start Date</th>
                        <th class="px-4 py-3 text-left font-medium text-neutral-600 dark:text-neutral-300">End Date</th>
                        <th class="px-4 py-3 text-right font-medium text-neutral-600 dark:text-neutral-300">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-100 dark:divide-neutral-700">
                    @forelse ($contracts as $contract)
                        <tr class="hover:bg-neutral-50 dark:hover:bg-zinc-800/50">
                            <td class="px-4 py-3 font-medium">
                                <a href="{{ route('crm.contracts.show', $contract) }}" class="text-blue-600 hover:underline">{{ $contract->subject }}</a>
                            </td>
                            <td class="px-4 py-3 text-neutral-600 dark:text-neutral-400">
                                {{ $contract->client ? $contract->client->first_name.' '.$contract->client->last_name : '—' }}
                            </td>
                            <td class="px-4 py-3 text-neutral-600 dark:text-neutral-400">{{ $contract->contract_type ?? '—' }}</td>
                            <td class="px-4 py-3 text-neutral-600 dark:text-neutral-400">{{ $contract->contract_value ? number_format($contract->contract_value, 2) : '—' }}</td>
                            <td class="px-4 py-3 text-neutral-600 dark:text-neutral-400">{{ $contract->start_date?->format('M d, Y') ?? '—' }}</td>
                            <td class="px-4 py-3 text-neutral-600 dark:text-neutral-400">{{ $contract->end_date?->format('M d, Y') ?? '—' }}</td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex justify-end gap-2">
                                    <flux:button href="{{ route('crm.contracts.edit', $contract) }}" size="sm" variant="ghost" icon="pencil" wire:navigate />
                                    <form method="POST" action="{{ route('crm.contracts.destroy', $contract) }}" onsubmit="return confirm('Delete this contract?')">
                                        @csrf @method('DELETE')
                                        <flux:button type="submit" size="sm" variant="ghost" icon="trash" class="text-red-500" />
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-neutral-400">No contracts found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div>{{ $contracts->links() }}</div>
    </div>
</x-layouts::app>
