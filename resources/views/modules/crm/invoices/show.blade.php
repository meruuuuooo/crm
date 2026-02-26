<x-layouts::app :title="__('Invoice Details')">
    <div class="mx-auto max-w-4xl space-y-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <flux:button href="{{ route('crm.invoices.index') }}" variant="ghost" icon="arrow-left" size="sm" wire:navigate />
                <flux:heading size="xl">Invoice #{{ str_pad($invoice->id, 4, '0', STR_PAD_LEFT) }}</flux:heading>
            </div>
            <div class="flex gap-2">
                <flux:button href="{{ route('crm.invoices.edit', $invoice) }}" variant="primary" icon="pencil" wire:navigate>Edit</flux:button>
                <form method="POST" action="{{ route('crm.invoices.destroy', $invoice) }}" onsubmit="return confirm('Delete this invoice?')">
                    @csrf @method('DELETE')
                    <flux:button type="submit" variant="danger" icon="trash">Delete</flux:button>
                </form>
            </div>
        </div>

        @include('modules.crm.partials.flash')

        {{-- Header Card --}}
        <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
            <div class="flex items-start justify-between">
                <div>
                    <flux:heading size="lg">Invoice Details</flux:heading>
                    <div class="mt-2">
                        @php $sc = ['Paid'=>'success','Overdue'=>'danger','Sent'=>'primary','Draft'=>'secondary','Cancelled'=>'zinc']; @endphp
                        <flux:badge variant="{{ $sc[$invoice->status] ?? 'secondary' }}">{{ $invoice->status ?? '—' }}</flux:badge>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-2xl font-bold">{{ $invoice->currency }} {{ $invoice->amount ? number_format($invoice->amount, 2) : '0.00' }}</div>
                    @if($invoice->payment_method)
                        <div class="mt-1 text-sm text-neutral-500">via {{ $invoice->payment_method }}</div>
                    @endif
                </div>
            </div>

            <div class="mt-6 grid grid-cols-2 gap-4 text-sm md:grid-cols-4">
                <div>
                    <dt class="font-medium text-neutral-500">Client</dt>
                    <dd class="mt-1">
                        @if($invoice->client)
                            <a href="{{ route('crm.contacts.show', $invoice->client) }}" class="text-blue-600 hover:underline">
                                {{ $invoice->client->first_name }} {{ $invoice->client->last_name }}
                            </a>
                        @else —
                        @endif
                    </dd>
                </div>
                <div>
                    <dt class="font-medium text-neutral-500">Project</dt>
                    <dd class="mt-1">
                        @if($invoice->project)
                            <a href="{{ route('crm.projects.show', $invoice->project) }}" class="text-blue-600 hover:underline">{{ $invoice->project->name }}</a>
                        @else —
                        @endif
                    </dd>
                </div>
                <div>
                    <dt class="font-medium text-neutral-500">Invoice Date</dt>
                    <dd class="mt-1">{{ $invoice->date?->format('M d, Y') ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="font-medium text-neutral-500">Due Date</dt>
                    <dd class="mt-1">{{ $invoice->open_till?->format('M d, Y') ?? '—' }}</dd>
                </div>
            </div>
        </div>

        {{-- Bill To / Ship To --}}
        @if($invoice->bill_to || $invoice->ship_to)
            <div class="grid grid-cols-2 gap-6">
                @if($invoice->bill_to)
                    <div class="rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-zinc-900">
                        <flux:heading size="sm" class="mb-2">Bill To</flux:heading>
                        <p class="text-sm whitespace-pre-line text-neutral-700 dark:text-neutral-300">{{ $invoice->bill_to }}</p>
                    </div>
                @endif
                @if($invoice->ship_to)
                    <div class="rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-zinc-900">
                        <flux:heading size="sm" class="mb-2">Ship To</flux:heading>
                        <p class="text-sm whitespace-pre-line text-neutral-700 dark:text-neutral-300">{{ $invoice->ship_to }}</p>
                    </div>
                @endif
            </div>
        @endif

        {{-- Line Items --}}
        @if($invoice->line_items && count($invoice->line_items))
            <div class="rounded-xl border border-neutral-200 bg-white dark:border-neutral-700 dark:bg-zinc-900">
                <div class="border-b border-neutral-100 px-6 py-4 dark:border-neutral-700">
                    <flux:heading size="lg">Line Items</flux:heading>
                </div>
                <table class="w-full text-sm">
                    <thead class="bg-neutral-50 dark:bg-zinc-800">
                        <tr>
                            <th class="px-4 py-3 text-left font-medium text-neutral-600 dark:text-neutral-300">Description</th>
                            <th class="px-4 py-3 text-right font-medium text-neutral-600 dark:text-neutral-300">Qty</th>
                            <th class="px-4 py-3 text-right font-medium text-neutral-600 dark:text-neutral-300">Unit Price</th>
                            <th class="px-4 py-3 text-right font-medium text-neutral-600 dark:text-neutral-300">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-100 dark:divide-neutral-700">
                        @foreach($invoice->line_items as $item)
                            <tr>
                                <td class="px-4 py-3">{{ $item['description'] ?? '—' }}</td>
                                <td class="px-4 py-3 text-right">{{ $item['qty'] ?? 1 }}</td>
                                <td class="px-4 py-3 text-right">{{ number_format($item['unit_price'] ?? 0, 2) }}</td>
                                <td class="px-4 py-3 text-right font-medium">{{ number_format($item['total'] ?? 0, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="bg-neutral-50 dark:bg-zinc-800">
                            <td colspan="3" class="px-4 py-3 text-right font-semibold">Total</td>
                            <td class="px-4 py-3 text-right font-bold text-lg">{{ $invoice->currency }} {{ number_format($invoice->amount ?? 0, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @endif

        {{-- Notes --}}
        @if($invoice->description || $invoice->notes || $invoice->terms_conditions)
            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900 space-y-4">
                @if($invoice->description)
                    <div>
                        <flux:heading size="sm" class="mb-1">Description</flux:heading>
                        <p class="text-sm text-neutral-700 dark:text-neutral-300">{{ $invoice->description }}</p>
                    </div>
                @endif
                @if($invoice->notes)
                    <div>
                        <flux:heading size="sm" class="mb-1">Notes</flux:heading>
                        <p class="text-sm text-neutral-700 dark:text-neutral-300">{{ $invoice->notes }}</p>
                    </div>
                @endif
                @if($invoice->terms_conditions)
                    <div>
                        <flux:heading size="sm" class="mb-1">Terms & Conditions</flux:heading>
                        <p class="text-sm text-neutral-700 dark:text-neutral-300">{{ $invoice->terms_conditions }}</p>
                    </div>
                @endif
            </div>
        @endif
    </div>
</x-layouts::app>
