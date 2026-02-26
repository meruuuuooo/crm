<x-layouts::app :title="__('Leads')">
    <div class="flex h-full w-full flex-1 flex-col gap-4">
        <div class="flex items-center justify-between">
            <flux:heading size="xl">Leads</flux:heading>
            <flux:button href="{{ route('crm.leads.create') }}" variant="primary" icon="plus" wire:navigate>Add Lead</flux:button>
        </div>
        @include('modules.crm.partials.flash')
        <div class="overflow-hidden rounded-xl border border-neutral-200 bg-white dark:border-neutral-700 dark:bg-zinc-900">
            <table class="w-full text-sm">
                <thead class="bg-neutral-50 dark:bg-zinc-800">
                    <tr>
                        <th class="px-4 py-3 text-left font-medium text-neutral-600 dark:text-neutral-300">Lead Name</th>
                        <th class="px-4 py-3 text-left font-medium text-neutral-600 dark:text-neutral-300">Type</th>
                        <th class="px-4 py-3 text-left font-medium text-neutral-600 dark:text-neutral-300">Company</th>
                        <th class="px-4 py-3 text-left font-medium text-neutral-600 dark:text-neutral-300">Value</th>
                        <th class="px-4 py-3 text-left font-medium text-neutral-600 dark:text-neutral-300">Source</th>
                        <th class="px-4 py-3 text-left font-medium text-neutral-600 dark:text-neutral-300">Visibility</th>
                        <th class="px-4 py-3 text-right font-medium text-neutral-600 dark:text-neutral-300">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-100 dark:divide-neutral-700">
                    @forelse ($leads as $lead)
                        <tr class="hover:bg-neutral-50 dark:hover:bg-zinc-800/50">
                            <td class="px-4 py-3 font-medium">
                                <a href="{{ route('crm.leads.show', $lead) }}" class="text-blue-600 hover:underline">{{ $lead->lead_name }}</a>
                            </td>
                            <td class="px-4 py-3"><flux:badge size="sm">{{ ucfirst($lead->lead_type) }}</flux:badge></td>
                            <td class="px-4 py-3 text-neutral-600 dark:text-neutral-400">{{ $lead->company?->company_name ?? '—' }}</td>
                            <td class="px-4 py-3 text-neutral-600 dark:text-neutral-400">{{ $lead->currency }} {{ number_format($lead->value ?? 0, 2) }}</td>
                            <td class="px-4 py-3 text-neutral-600 dark:text-neutral-400">{{ $lead->source ?? '—' }}</td>
                            <td class="px-4 py-3"><flux:badge size="sm">{{ ucfirst($lead->visibility) }}</flux:badge></td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex justify-end gap-2">
                                    <flux:button href="{{ route('crm.leads.edit', $lead) }}" size="sm" variant="ghost" icon="pencil" wire:navigate />
                                    <form method="POST" action="{{ route('crm.leads.destroy', $lead) }}" onsubmit="return confirm('Delete?')">
                                        @csrf @method('DELETE')
                                        <flux:button type="submit" size="sm" variant="ghost" icon="trash" class="text-red-500" />
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="px-4 py-8 text-center text-neutral-400">No leads found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div>{{ $leads->links() }}</div>
    </div>
</x-layouts::app>
