<x-layouts::app :title="__('Proposals')">
    <div class="flex h-full w-full flex-1 flex-col gap-4">
        <div class="flex items-center justify-between">
            <flux:heading size="xl">Proposals</flux:heading>
            <flux:button href="{{ route('crm.proposals.create') }}" variant="primary" icon="plus" wire:navigate>Add Proposal</flux:button>
        </div>

        @include('modules.crm.partials.flash')

        <div class="overflow-hidden rounded-xl border border-neutral-200 bg-white dark:border-neutral-700 dark:bg-zinc-900">
            <table class="w-full text-sm">
                <thead class="bg-neutral-50 dark:bg-zinc-800">
                    <tr>
                        <th class="px-4 py-3 text-left font-medium text-neutral-600 dark:text-neutral-300">Subject</th>
                        <th class="px-4 py-3 text-left font-medium text-neutral-600 dark:text-neutral-300">Client</th>
                        <th class="px-4 py-3 text-left font-medium text-neutral-600 dark:text-neutral-300">Date</th>
                        <th class="px-4 py-3 text-left font-medium text-neutral-600 dark:text-neutral-300">Open Till</th>
                        <th class="px-4 py-3 text-left font-medium text-neutral-600 dark:text-neutral-300">Currency</th>
                        <th class="px-4 py-3 text-left font-medium text-neutral-600 dark:text-neutral-300">Status</th>
                        <th class="px-4 py-3 text-right font-medium text-neutral-600 dark:text-neutral-300">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-100 dark:divide-neutral-700">
                    @forelse ($proposals as $proposal)
                        <tr class="hover:bg-neutral-50 dark:hover:bg-zinc-800/50">
                            <td class="px-4 py-3 font-medium">
                                <a href="{{ route('crm.proposals.show', $proposal) }}" class="text-blue-600 hover:underline">{{ $proposal->subject }}</a>
                            </td>
                            <td class="px-4 py-3 text-neutral-600 dark:text-neutral-400">
                                {{ $proposal->client ? $proposal->client->first_name.' '.$proposal->client->last_name : '—' }}
                            </td>
                            <td class="px-4 py-3 text-neutral-600 dark:text-neutral-400">{{ $proposal->date?->format('M d, Y') ?? '—' }}</td>
                            <td class="px-4 py-3 text-neutral-600 dark:text-neutral-400">{{ $proposal->open_till?->format('M d, Y') ?? '—' }}</td>
                            <td class="px-4 py-3 text-neutral-600 dark:text-neutral-400">{{ $proposal->currency ?? '—' }}</td>
                            <td class="px-4 py-3">
                                @php $sc = ['Accepted'=>'success','Declined'=>'danger','Sent'=>'primary','Draft'=>'secondary','Expired'=>'zinc']; @endphp
                                <flux:badge variant="{{ $sc[$proposal->status] ?? 'secondary' }}" size="sm">{{ $proposal->status ?? '—' }}</flux:badge>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex justify-end gap-2">
                                    <flux:button href="{{ route('crm.proposals.edit', $proposal) }}" size="sm" variant="ghost" icon="pencil" wire:navigate />
                                    <form method="POST" action="{{ route('crm.proposals.destroy', $proposal) }}" onsubmit="return confirm('Delete this proposal?')">
                                        @csrf @method('DELETE')
                                        <flux:button type="submit" size="sm" variant="ghost" icon="trash" class="text-red-500" />
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-neutral-400">No proposals found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div>{{ $proposals->links() }}</div>
    </div>
</x-layouts::app>
