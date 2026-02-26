<x-layouts::app :title="__('Estimations')">
    <div class="flex h-full w-full flex-1 flex-col gap-4">
        <div class="flex items-center justify-between">
            <flux:heading size="xl">Estimations</flux:heading>
            <flux:button href="{{ route('crm.estimations.create') }}" variant="primary" icon="plus" wire:navigate>Add Estimation</flux:button>
        </div>

        @include('modules.crm.partials.flash')

        <div class="overflow-hidden rounded-xl border border-neutral-200 bg-white dark:border-neutral-700 dark:bg-zinc-900">
            <table class="w-full text-sm">
                <thead class="bg-neutral-50 dark:bg-zinc-800">
                    <tr>
                        <th class="px-4 py-3 text-left font-medium text-neutral-600 dark:text-neutral-300">Client</th>
                        <th class="px-4 py-3 text-left font-medium text-neutral-600 dark:text-neutral-300">Project</th>
                        <th class="px-4 py-3 text-left font-medium text-neutral-600 dark:text-neutral-300">Amount</th>
                        <th class="px-4 py-3 text-left font-medium text-neutral-600 dark:text-neutral-300">Currency</th>
                        <th class="px-4 py-3 text-left font-medium text-neutral-600 dark:text-neutral-300">Est. Date</th>
                        <th class="px-4 py-3 text-left font-medium text-neutral-600 dark:text-neutral-300">Expiry</th>
                        <th class="px-4 py-3 text-left font-medium text-neutral-600 dark:text-neutral-300">Status</th>
                        <th class="px-4 py-3 text-right font-medium text-neutral-600 dark:text-neutral-300">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-100 dark:divide-neutral-700">
                    @forelse ($estimations as $estimation)
                        <tr class="hover:bg-neutral-50 dark:hover:bg-zinc-800/50">
                            <td class="px-4 py-3 font-medium">
                                <a href="{{ route('crm.estimations.show', $estimation) }}" class="text-blue-600 hover:underline">
                                    {{ $estimation->client ? $estimation->client->first_name.' '.$estimation->client->last_name : 'N/A' }}
                                </a>
                            </td>
                            <td class="px-4 py-3 text-neutral-600 dark:text-neutral-400">{{ $estimation->project?->name ?? '—' }}</td>
                            <td class="px-4 py-3 text-neutral-600 dark:text-neutral-400">{{ $estimation->amount ? number_format($estimation->amount, 2) : '—' }}</td>
                            <td class="px-4 py-3 text-neutral-600 dark:text-neutral-400">{{ $estimation->currency ?? '—' }}</td>
                            <td class="px-4 py-3 text-neutral-600 dark:text-neutral-400">{{ $estimation->estimate_date?->format('M d, Y') ?? '—' }}</td>
                            <td class="px-4 py-3 text-neutral-600 dark:text-neutral-400">{{ $estimation->expiry_date?->format('M d, Y') ?? '—' }}</td>
                            <td class="px-4 py-3">
                                @php $sc = ['Approved'=>'success','Declined'=>'danger','Sent'=>'primary','Draft'=>'secondary','Expired'=>'zinc']; @endphp
                                <flux:badge variant="{{ $sc[$estimation->status] ?? 'secondary' }}" size="sm">{{ $estimation->status ?? '—' }}</flux:badge>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex justify-end gap-2">
                                    <flux:button href="{{ route('crm.estimations.edit', $estimation) }}" size="sm" variant="ghost" icon="pencil" wire:navigate />
                                    <form method="POST" action="{{ route('crm.estimations.destroy', $estimation) }}" onsubmit="return confirm('Delete this estimation?')">
                                        @csrf @method('DELETE')
                                        <flux:button type="submit" size="sm" variant="ghost" icon="trash" class="text-red-500" />
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-8 text-center text-neutral-400">No estimations found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div>{{ $estimations->links() }}</div>
    </div>
</x-layouts::app>
