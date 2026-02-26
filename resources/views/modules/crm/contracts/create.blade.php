<x-layouts::app :title="__('Add Contract')">
    <div class="mx-auto max-w-4xl">
        <div class="mb-6 flex items-center gap-3">
            <flux:button href="{{ route('crm.contracts.index') }}" variant="ghost" icon="arrow-left" size="sm" wire:navigate />
            <flux:heading size="xl">Add Contract</flux:heading>
        </div>

        @include('modules.crm.partials.flash')

        <form method="POST" action="{{ route('crm.contracts.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
                <flux:heading size="lg" class="mb-4">Contract Details</flux:heading>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <flux:input name="subject" label="Subject *" value="{{ old('subject') }}" required class="md:col-span-2" />
                    <flux:select name="client_id" label="Client" placeholder="Select Client">
                        @foreach($contacts as $c)
                            <flux:select.option value="{{ $c->id }}" :selected="old('client_id') == $c->id">{{ $c->first_name }} {{ $c->last_name }}</flux:select.option>
                        @endforeach
                    </flux:select>
                    <flux:select name="contract_type" label="Contract Type" placeholder="Select Type">
                        @foreach(\App\Helpers\CrmOptions::contractTypes() as $t)
                            <flux:select.option value="{{ $t }}" :selected="old('contract_type') === $t">{{ $t }}</flux:select.option>
                        @endforeach
                    </flux:select>
                    <flux:input name="contract_value" label="Contract Value" type="number" step="0.01" min="0" value="{{ old('contract_value') }}" />
                    <flux:input name="start_date" label="Start Date" type="date" value="{{ old('start_date') }}" />
                    <flux:input name="end_date" label="End Date" type="date" value="{{ old('end_date') }}" />
                    <div>
                        <flux:label>Attachment</flux:label>
                        <input type="file" name="attachment" class="mt-1 block w-full text-sm text-neutral-600 file:mr-3 file:rounded-lg file:border-0 file:bg-blue-50 file:px-4 file:py-2 file:text-sm file:font-medium file:text-blue-700 hover:file:bg-blue-100" />
                    </div>
                    <div class="md:col-span-2">
                        <flux:textarea name="description" label="Description" rows="4">{{ old('description') }}</flux:textarea>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <flux:button href="{{ route('crm.contracts.index') }}" variant="ghost" wire:navigate>Cancel</flux:button>
                <flux:button type="submit" variant="primary">Save Contract</flux:button>
            </div>
        </form>
    </div>
</x-layouts::app>
