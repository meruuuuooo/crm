<x-layouts::app :title="__('Edit Contract')">
    <div class="mx-auto max-w-4xl">
        <div class="mb-6 flex items-center gap-3">
            <flux:button href="{{ route('crm.contracts.show', $contract) }}" variant="ghost" icon="arrow-left" size="sm" wire:navigate />
            <flux:heading size="xl">Edit Contract</flux:heading>
        </div>

        @include('modules.crm.partials.flash')

        <form method="POST" action="{{ route('crm.contracts.update', $contract) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf @method('PUT')

            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
                <flux:heading size="lg" class="mb-4">Contract Details</flux:heading>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <flux:input name="subject" label="Subject *" value="{{ old('subject', $contract->subject) }}" required class="md:col-span-2" />
                    <flux:select name="client_id" label="Client" placeholder="Select Client">
                        @foreach($contacts as $c)
                            <flux:select.option value="{{ $c->id }}" :selected="old('client_id', $contract->client_id) == $c->id">{{ $c->first_name }} {{ $c->last_name }}</flux:select.option>
                        @endforeach
                    </flux:select>
                    <flux:select name="contract_type" label="Contract Type" placeholder="Select Type">
                        @foreach(\App\Helpers\CrmOptions::contractTypes() as $t)
                            <flux:select.option value="{{ $t }}" :selected="old('contract_type', $contract->contract_type) === $t">{{ $t }}</flux:select.option>
                        @endforeach
                    </flux:select>
                    <flux:input name="contract_value" label="Contract Value" type="number" step="0.01" min="0" value="{{ old('contract_value', $contract->contract_value) }}" />
                    <flux:input name="start_date" label="Start Date" type="date" value="{{ old('start_date', $contract->start_date?->format('Y-m-d')) }}" />
                    <flux:input name="end_date" label="End Date" type="date" value="{{ old('end_date', $contract->end_date?->format('Y-m-d')) }}" />
                    <div>
                        <flux:label>Attachment</flux:label>
                        @if($contract->attachment)
                            <p class="mb-1 text-xs text-neutral-500">Current: {{ basename($contract->attachment) }}</p>
                        @endif
                        <input type="file" name="attachment" class="mt-1 block w-full text-sm text-neutral-600 file:mr-3 file:rounded-lg file:border-0 file:bg-blue-50 file:px-4 file:py-2 file:text-sm file:font-medium file:text-blue-700 hover:file:bg-blue-100" />
                    </div>
                    <div class="md:col-span-2">
                        <flux:textarea name="description" label="Description" rows="4">{{ old('description', $contract->description) }}</flux:textarea>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <flux:button href="{{ route('crm.contracts.show', $contract) }}" variant="ghost" wire:navigate>Cancel</flux:button>
                <flux:button type="submit" variant="primary">Update Contract</flux:button>
            </div>
        </form>
    </div>
</x-layouts::app>
