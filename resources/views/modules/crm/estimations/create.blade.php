<x-layouts::app :title="__('Add Estimation')">
    <div class="mx-auto max-w-4xl">
        <div class="mb-6 flex items-center gap-3">
            <flux:button href="{{ route('crm.estimations.index') }}" variant="ghost" icon="arrow-left" size="sm" wire:navigate />
            <flux:heading size="xl">Add Estimation</flux:heading>
        </div>

        @include('modules.crm.partials.flash')

        <form method="POST" action="{{ route('crm.estimations.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
                <flux:heading size="lg" class="mb-4">Estimation Details</flux:heading>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <flux:select name="client_id" label="Client *" placeholder="Select Client">
                        @foreach($contacts as $c)
                            <flux:select.option value="{{ $c->id }}" :selected="old('client_id') == $c->id">{{ $c->first_name }} {{ $c->last_name }}</flux:select.option>
                        @endforeach
                    </flux:select>
                    <flux:select name="project_id" label="Project" placeholder="Select Project">
                        @foreach($projects as $p)
                            <flux:select.option value="{{ $p->id }}" :selected="old('project_id') == $p->id">{{ $p->name }}</flux:select.option>
                        @endforeach
                    </flux:select>
                    <flux:textarea name="bill_to" label="Bill To" rows="3">{{ old('bill_to') }}</flux:textarea>
                    <flux:textarea name="ship_to" label="Ship To" rows="3">{{ old('ship_to') }}</flux:textarea>
                    <flux:input name="estimate_by" label="Estimate By" value="{{ old('estimate_by') }}" placeholder="Person or team" />
                    <flux:input name="amount" label="Amount" type="number" step="0.01" min="0" value="{{ old('amount') }}" />
                    <flux:select name="currency" label="Currency" placeholder="Select Currency">
                        @foreach(\App\Helpers\CrmOptions::currencies() as $cur)
                            <flux:select.option value="{{ $cur }}" :selected="old('currency') === $cur">{{ $cur }}</flux:select.option>
                        @endforeach
                    </flux:select>
                    <flux:input name="estimate_date" label="Estimate Date" type="date" value="{{ old('estimate_date') }}" />
                    <flux:input name="expiry_date" label="Expiry Date" type="date" value="{{ old('expiry_date') }}" />
                    <flux:select name="status" label="Status" placeholder="Select Status">
                        @foreach(\App\Helpers\CrmOptions::estimationStatuses() as $s)
                            <flux:select.option value="{{ $s }}" :selected="old('status') === $s">{{ $s }}</flux:select.option>
                        @endforeach
                    </flux:select>
                    <flux:input name="tags" label="Tags" value="{{ old('tags') }}" placeholder="e.g. Q4, high-value" />
                    <div>
                        <flux:label>Attachment</flux:label>
                        <input type="file" name="attachment" class="mt-1 block w-full text-sm text-neutral-600 file:mr-3 file:rounded-lg file:border-0 file:bg-blue-50 file:px-4 file:py-2 file:text-sm file:font-medium file:text-blue-700 hover:file:bg-blue-100" />
                    </div>
                    <div class="md:col-span-2">
                        <flux:textarea name="description" label="Description / Notes" rows="4">{{ old('description') }}</flux:textarea>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <flux:button href="{{ route('crm.estimations.index') }}" variant="ghost" wire:navigate>Cancel</flux:button>
                <flux:button type="submit" variant="primary">Save Estimation</flux:button>
            </div>
        </form>
    </div>
</x-layouts::app>
