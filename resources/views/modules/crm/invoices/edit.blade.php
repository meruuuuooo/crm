<x-layouts::app :title="__('Edit Invoice')">
    <div class="mx-auto max-w-4xl">
        <div class="mb-6 flex items-center gap-3">
            <flux:button href="{{ route('crm.invoices.show', $invoice) }}" variant="ghost" icon="arrow-left" size="sm" wire:navigate />
            <flux:heading size="xl">Edit Invoice</flux:heading>
        </div>

        @include('modules.crm.partials.flash')

        <form method="POST" action="{{ route('crm.invoices.update', $invoice) }}" class="space-y-6">
            @csrf @method('PUT')

            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
                <flux:heading size="lg" class="mb-4">Invoice Details</flux:heading>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <flux:select name="client_id" label="Client *" placeholder="Select Client">
                        @foreach($contacts as $c)
                            <flux:select.option value="{{ $c->id }}" :selected="old('client_id', $invoice->client_id) == $c->id">{{ $c->first_name }} {{ $c->last_name }}</flux:select.option>
                        @endforeach
                    </flux:select>
                    <flux:select name="project_id" label="Project" placeholder="Select Project">
                        @foreach($projects as $p)
                            <flux:select.option value="{{ $p->id }}" :selected="old('project_id', $invoice->project_id) == $p->id">{{ $p->name }}</flux:select.option>
                        @endforeach
                    </flux:select>
                    <flux:textarea name="bill_to" label="Bill To" rows="3">{{ old('bill_to', $invoice->bill_to) }}</flux:textarea>
                    <flux:textarea name="ship_to" label="Ship To" rows="3">{{ old('ship_to', $invoice->ship_to) }}</flux:textarea>
                    <flux:input name="amount" label="Amount" type="number" step="0.01" min="0" value="{{ old('amount', $invoice->amount) }}" />
                    <flux:select name="currency" label="Currency" placeholder="Select Currency">
                        @foreach(\App\Helpers\CrmOptions::currencies() as $cur)
                            <flux:select.option value="{{ $cur }}" :selected="old('currency', $invoice->currency) === $cur">{{ $cur }}</flux:select.option>
                        @endforeach
                    </flux:select>
                    <flux:input name="date" label="Invoice Date" type="date" value="{{ old('date', $invoice->date?->format('Y-m-d')) }}" />
                    <flux:input name="open_till" label="Due Date" type="date" value="{{ old('open_till', $invoice->open_till?->format('Y-m-d')) }}" />
                    <flux:select name="payment_method" label="Payment Method" placeholder="Select Method">
                        @foreach(\App\Helpers\CrmOptions::paymentMethods() as $m)
                            <flux:select.option value="{{ $m }}" :selected="old('payment_method', $invoice->payment_method) === $m">{{ $m }}</flux:select.option>
                        @endforeach
                    </flux:select>
                    <flux:select name="status" label="Status" placeholder="Select Status">
                        @foreach(\App\Helpers\CrmOptions::invoiceStatuses() as $s)
                            <flux:select.option value="{{ $s }}" :selected="old('status', $invoice->status) === $s">{{ $s }}</flux:select.option>
                        @endforeach
                    </flux:select>
                </div>
            </div>

            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900" id="line-items-section">
                <div class="mb-4 flex items-center justify-between">
                    <flux:heading size="lg">Line Items</flux:heading>
                    <flux:button type="button" variant="ghost" icon="plus" size="sm" id="add-line-item">Add Item</flux:button>
                </div>
                <div class="space-y-2" id="line-items-container">
                    @php $lineItems = old('line_items', $invoice->line_items ?? []); @endphp
                    @forelse($lineItems as $i => $item)
                        <div class="grid grid-cols-12 gap-2 rounded-lg border border-neutral-100 bg-neutral-50 px-3 py-2 dark:border-neutral-700 dark:bg-zinc-800 line-item-row">
                            <div class="col-span-5"><input type="text" name="line_items[{{ $i }}][description]" placeholder="Description" class="w-full rounded border border-neutral-300 px-2 py-1.5 text-sm dark:border-neutral-600 dark:bg-zinc-900 dark:text-white" value="{{ $item['description'] ?? '' }}" /></div>
                            <div class="col-span-2"><input type="number" name="line_items[{{ $i }}][qty]" placeholder="Qty" min="1" class="w-full rounded border border-neutral-300 px-2 py-1.5 text-sm dark:border-neutral-600 dark:bg-zinc-900 dark:text-white" value="{{ $item['qty'] ?? 1 }}" /></div>
                            <div class="col-span-2"><input type="number" name="line_items[{{ $i }}][unit_price]" placeholder="Unit Price" step="0.01" class="w-full rounded border border-neutral-300 px-2 py-1.5 text-sm dark:border-neutral-600 dark:bg-zinc-900 dark:text-white" value="{{ $item['unit_price'] ?? '' }}" /></div>
                            <div class="col-span-2"><input type="number" name="line_items[{{ $i }}][total]" placeholder="Total" step="0.01" readonly class="w-full rounded border border-neutral-200 bg-neutral-100 px-2 py-1.5 text-sm dark:border-neutral-600 dark:bg-zinc-800 dark:text-white" value="{{ $item['total'] ?? '' }}" /></div>
                            <div class="col-span-1 flex items-center justify-center"><button type="button" class="text-red-400 hover:text-red-600 remove-line-item">✕</button></div>
                        </div>
                    @empty
                        <div class="grid grid-cols-12 gap-2 rounded-lg border border-neutral-100 bg-neutral-50 px-3 py-2 dark:border-neutral-700 dark:bg-zinc-800 line-item-row">
                            <div class="col-span-5"><input type="text" name="line_items[0][description]" placeholder="Description" class="w-full rounded border border-neutral-300 px-2 py-1.5 text-sm dark:border-neutral-600 dark:bg-zinc-900 dark:text-white" /></div>
                            <div class="col-span-2"><input type="number" name="line_items[0][qty]" placeholder="Qty" min="1" value="1" class="w-full rounded border border-neutral-300 px-2 py-1.5 text-sm dark:border-neutral-600 dark:bg-zinc-900 dark:text-white" /></div>
                            <div class="col-span-2"><input type="number" name="line_items[0][unit_price]" placeholder="Unit Price" step="0.01" class="w-full rounded border border-neutral-300 px-2 py-1.5 text-sm dark:border-neutral-600 dark:bg-zinc-900 dark:text-white" /></div>
                            <div class="col-span-2"><input type="number" name="line_items[0][total]" placeholder="Total" step="0.01" readonly class="w-full rounded border border-neutral-200 bg-neutral-100 px-2 py-1.5 text-sm dark:border-neutral-600 dark:bg-zinc-800 dark:text-white" /></div>
                            <div class="col-span-1 flex items-center justify-center"><button type="button" class="text-red-400 hover:text-red-600 remove-line-item">✕</button></div>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
                <flux:heading size="lg" class="mb-4">Additional Info</flux:heading>
                <div class="grid grid-cols-1 gap-4">
                    <flux:textarea name="description" label="Description" rows="3">{{ old('description', $invoice->description) }}</flux:textarea>
                    <flux:textarea name="notes" label="Notes" rows="3">{{ old('notes', $invoice->notes) }}</flux:textarea>
                    <flux:textarea name="terms_conditions" label="Terms & Conditions" rows="3">{{ old('terms_conditions', $invoice->terms_conditions) }}</flux:textarea>
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <flux:button href="{{ route('crm.invoices.show', $invoice) }}" variant="ghost" wire:navigate>Cancel</flux:button>
                <flux:button type="submit" variant="primary">Update Invoice</flux:button>
            </div>
        </form>
    </div>

    <script>
        let itemCount = {{ count($invoice->line_items ?? []) ?: 1 }};
        const container = document.getElementById('line-items-container');

        function calcTotal(row) {
            const qty = parseFloat(row.querySelector('[name*="[qty]"]').value) || 0;
            const price = parseFloat(row.querySelector('[name*="[unit_price]"]').value) || 0;
            row.querySelector('[name*="[total]"]').value = (qty * price).toFixed(2);
        }

        container.addEventListener('input', e => {
            const row = e.target.closest('.line-item-row');
            if (row) calcTotal(row);
        });

        container.addEventListener('click', e => {
            if (e.target.classList.contains('remove-line-item')) {
                if (container.querySelectorAll('.line-item-row').length > 1) {
                    e.target.closest('.line-item-row').remove();
                }
            }
        });

        document.getElementById('add-line-item').addEventListener('click', () => {
            const row = document.createElement('div');
            row.className = 'grid grid-cols-12 gap-2 rounded-lg border border-neutral-100 bg-neutral-50 px-3 py-2 dark:border-neutral-700 dark:bg-zinc-800 line-item-row';
            row.innerHTML = `
                <div class="col-span-5"><input type="text" name="line_items[${itemCount}][description]" placeholder="Description" class="w-full rounded border border-neutral-300 px-2 py-1.5 text-sm dark:border-neutral-600 dark:bg-zinc-900 dark:text-white" /></div>
                <div class="col-span-2"><input type="number" name="line_items[${itemCount}][qty]" placeholder="Qty" min="1" value="1" class="w-full rounded border border-neutral-300 px-2 py-1.5 text-sm dark:border-neutral-600 dark:bg-zinc-900 dark:text-white" /></div>
                <div class="col-span-2"><input type="number" name="line_items[${itemCount}][unit_price]" placeholder="Unit Price" step="0.01" class="w-full rounded border border-neutral-300 px-2 py-1.5 text-sm dark:border-neutral-600 dark:bg-zinc-900 dark:text-white" /></div>
                <div class="col-span-2"><input type="number" name="line_items[${itemCount}][total]" placeholder="Total" step="0.01" readonly class="w-full rounded border border-neutral-200 bg-neutral-100 px-2 py-1.5 text-sm dark:border-neutral-600 dark:bg-zinc-800 dark:text-white" /></div>
                <div class="col-span-1 flex items-center justify-center"><button type="button" class="text-red-400 hover:text-red-600 remove-line-item">✕</button></div>
            `;
            container.appendChild(row);
            itemCount++;
        });
    </script>
</x-layouts::app>
