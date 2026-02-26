<x-layouts::app :title="__('Campaigns')">
    <div class="flex h-full w-full flex-1 flex-col gap-4">
        <div class="flex items-center justify-between">
            <flux:heading size="xl">Campaigns</flux:heading>
            <flux:button href="{{ route('crm.campaigns.create') }}" variant="primary" icon="plus" wire:navigate>Add Campaign</flux:button>
        </div>
        @include('modules.crm.partials.flash')
        <div class="overflow-hidden rounded-xl border border-neutral-200 bg-white dark:border-neutral-700 dark:bg-zinc-900">
            <table class="w-full text-sm">
                <thead class="bg-neutral-50 dark:bg-zinc-800">
                    <tr>
                        <th class="px-4 py-3 text-left font-medium text-neutral-600 dark:text-neutral-300">Name</th>
                        <th class="px-4 py-3 text-left font-medium text-neutral-600 dark:text-neutral-300">Type</th>
                        <th class="px-4 py-3 text-left font-medium text-neutral-600 dark:text-neutral-300">Deal Value</th>
                        <th class="px-4 py-3 text-left font-medium text-neutral-600 dark:text-neutral-300">Period</th>
                        <th class="px-4 py-3 text-left font-medium text-neutral-600 dark:text-neutral-300">Target Audience</th>
                        <th class="px-4 py-3 text-right font-medium text-neutral-600 dark:text-neutral-300">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-100 dark:divide-neutral-700">
                    @forelse ($campaigns as $campaign)
                        <tr class="hover:bg-neutral-50 dark:hover:bg-zinc-800/50">
                            <td class="px-4 py-3 font-medium"><a href="{{ route('crm.campaigns.show', $campaign) }}" class="text-blue-600 hover:underline">{{ $campaign->name }}</a></td>
                            <td class="px-4 py-3 text-neutral-600 dark:text-neutral-400">{{ $campaign->campaign_type ?? '—' }}</td>
                            <td class="px-4 py-3 text-neutral-600 dark:text-neutral-400">{{ $campaign->currency }} {{ number_format($campaign->deal_value ?? 0, 2) }}</td>
                            <td class="px-4 py-3 text-neutral-600 dark:text-neutral-400">{{ $campaign->period ?? '—' }}</td>
                            <td class="px-4 py-3 text-neutral-600 dark:text-neutral-400">{{ $campaign->target_audience ?? '—' }}</td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex justify-end gap-2">
                                    <flux:button href="{{ route('crm.campaigns.edit', $campaign) }}" size="sm" variant="ghost" icon="pencil" wire:navigate />
                                    <form method="POST" action="{{ route('crm.campaigns.destroy', $campaign) }}" onsubmit="return confirm('Delete?')">
                                        @csrf @method('DELETE')
                                        <flux:button type="submit" size="sm" variant="ghost" icon="trash" class="text-red-500" />
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-4 py-8 text-center text-neutral-400">No campaigns found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div>{{ $campaigns->links() }}</div>
    </div>
</x-layouts::app>
