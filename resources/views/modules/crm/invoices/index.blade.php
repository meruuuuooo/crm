<x-layouts::app :title="__('Invoices')">
    <div class="flex h-full w-full flex-1 flex-col gap-4">
        <div class="flex items-center justify-between">
            <flux:heading size="xl">Invoices</flux:heading>
            <flux:button href="{{ route('crm.invoices.create') }}" variant="primary" icon="plus" wire:navigate>Add Invoice</flux:button>
        </div>

        @include('modules.crm.partials.flash')

        <div class="overflow-hidden rounded-xl border border-neutral-200 bg-white dark:border-neutral-700 dark:bg-zinc-900">
            <table class="w-full text-sm">
                <thead class="bg-neutral-50 dark:bg-zinc-800">
                    <tr>
                        <th class="px-4 py-3 text-left font-medium text-neutral-600 dark:text-neutral-300">#</th>
                        <th class="px-4 py-3 text-left font-medium text-neutral-600 dark:text-neutral-300">Client</th>
                        <th class="px-4 py-3 text-left font-medium text-neutral-600 dark:text-neutral-300">Project</th>
                        <th class="px-4 py-3 text-left font-medium text-neutral-600 dark:text-neutral-300">Amount</th>
                        <th class="px-4 py-3 text-left font-medium text-neutral-600 dark:text-neutral-300">Date</th>
                        <th class="px-4 py-3 text-left font-medium text-neutral-600 dark:text-neutral-300">Due Date</th>
                        <th class="px-4 py-3 text-left font-medium text-neutral-600 dark:text-neutral-300">Status</th>
                        <th class="px-4 py-3 text-right font-medium text-neutral-600 dark:text-neutral-300">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-100 dark:divide-neutral-700">
                    @forelse ($invoices as $invoice)
                        <tr class="hover:bg-neutral-50 dark:hover:bg-zinc-800/50">
                            <td class="px-4 py-3 font-medium">
                                <a href="{{ route('crm.invoices.show', $invoice) }}" class="text-blue-600 hover:underline">INV-{{ str_pad($invoice->id, 4, '0', STR_PAD_LEFT) }}</a>
                            </td>
                            <td class="px-4 py-3 text-neutral-600 dark:text-neutral-400">
                                {{ $invoice->client ? $invoice->client->first_name.' '.$invoice->client->last_name : '—' }}
                            </td>
                            <td class="px-4 py-3 text-neutral-600 dark:text-neutral-400">{{ $invoice->project?->name ?? '—' }}</td>
                            <td class="px-4 py-3 font-medium">{{ $invoice->currency }} {{ $invoice->amount ? number_format($invoice->amount, 2) : '—' }}</td>
                            <td class="px-4 py-3 text-neutral-600 dark:text-neutral-400">{{ $invoice->date?->format('M d, Y') ?? '—' }}</td>
                            <td class="px-4 py-3 text-neutral-600 dark:text-neutral-400">{{ $invoice->open_till?->format('M d, Y') ?? '—' }}</td>
                            <td class="px-4 py-3">
                                @php $sc = ['Paid'=>'success','Overdue'=>'danger','Sent'=>'primary','Draft'=>'secondary','Cancelled'=>'zinc']; @endphp
                                <flux:badge variant="{{ $sc[$invoice->status] ?? 'secondary' }}" size="sm">{{ $invoice->status ?? '—' }}</flux:badge>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex justify-end gap-2">
                                    <flux:button href="{{ route('crm.invoices.edit', $invoice) }}" size="sm" variant="ghost" icon="pencil" wire:navigate />
                                    <form method="POST" action="{{ route('crm.invoices.destroy', $invoice) }}" onsubmit="return confirm('Delete this invoice?')">
                                        @csrf @method('DELETE')
                                        <flux:button type="submit" size="sm" variant="ghost" icon="trash" class="text-red-500" />
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-8 text-center text-neutral-400">No invoices found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div>{{ $invoices->links() }}</div>
    </div>
</x-layouts::app>
