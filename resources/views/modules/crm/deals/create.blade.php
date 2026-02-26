<x-layouts::app :title="__('Add Deal')">
    <div class="mx-auto max-w-4xl">
        <div class="mb-6 flex items-center gap-3">
            <flux:button href="{{ route('crm.deals.index') }}" variant="ghost" icon="arrow-left" size="sm" wire:navigate />
            <flux:heading size="xl">Add Deal</flux:heading>
        </div>

        @include('modules.crm.partials.flash')

        <form method="POST" action="{{ route('crm.deals.store') }}" class="space-y-6">
            @csrf

            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
                <flux:heading size="lg" class="mb-4">Basic Information</flux:heading>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

                    <flux:input name="deal_name" label="Deal Name *" value="{{ old('deal_name') }}" required class="md:col-span-2" />

                    <flux:select name="pipeline_id" label="Pipeline" placeholder="Select Pipeline">
                        @foreach($pipelines as $pipeline)
                            <flux:select.option value="{{ $pipeline->id }}" :selected="old('pipeline_id') == $pipeline->id">{{ $pipeline->name }}</flux:select.option>
                        @endforeach
                    </flux:select>

                    <flux:select name="status" label="Status" placeholder="Select Status">
                        @foreach(\App\Helpers\CrmOptions::dealStatuses() as $s)
                            <flux:select.option value="{{ $s }}" :selected="old('status') === $s">{{ $s }}</flux:select.option>
                        @endforeach
                    </flux:select>

                    <flux:input name="deal_value" label="Deal Value" type="number" step="0.01" value="{{ old('deal_value') }}" />

                    <flux:select name="currency" label="Currency" placeholder="Select Currency">
                        @foreach(\App\Helpers\CrmOptions::currencies() as $cur)
                            <flux:select.option value="{{ $cur }}" :selected="old('currency') === $cur">{{ $cur }}</flux:select.option>
                        @endforeach
                    </flux:select>

                    <flux:select name="period" label="Period" placeholder="Select Period">
                        @foreach(\App\Helpers\CrmOptions::periods() as $p)
                            <flux:select.option value="{{ $p }}" :selected="old('period') === $p">{{ $p }}</flux:select.option>
                        @endforeach
                    </flux:select>

                    <flux:input name="period_value" label="Period Value" type="number" step="0.01" value="{{ old('period_value') }}" />
                    <flux:input name="project" label="Project" value="{{ old('project') }}" />
                    <flux:input name="due_date" label="Due Date" type="date" value="{{ old('due_date') }}" />
                    <flux:input name="expected_closing_date" label="Expected Closing Date" type="date" value="{{ old('expected_closing_date') }}" />
                    <flux:input name="follow_up_date" label="Follow Up Date" type="date" value="{{ old('follow_up_date') }}" />

                    <flux:select name="source" label="Source" placeholder="Select Source">
                        @foreach(\App\Helpers\CrmOptions::sources() as $src)
                            <flux:select.option value="{{ $src }}" :selected="old('source') === $src">{{ $src }}</flux:select.option>
                        @endforeach
                    </flux:select>

                    <flux:input name="tags" label="Tags" value="{{ old('tags') }}" placeholder="Comma-separated tags" />

                    <flux:select name="priority" label="Priority" placeholder="Select Priority">
                        @foreach(\App\Helpers\CrmOptions::priorities() as $pri)
                            <flux:select.option value="{{ $pri }}" :selected="old('priority') === $pri">{{ $pri }}</flux:select.option>
                        @endforeach
                    </flux:select>

                    <div class="md:col-span-2">
                        <flux:label class="mb-1">Contacts (multiple)</flux:label>
                        <select name="contacts[]" multiple class="w-full rounded-lg border border-neutral-300 p-2 text-sm dark:border-neutral-600 dark:bg-zinc-800">
                            @foreach($contacts as $contact)
                                <option value="{{ $contact->id }}">{{ $contact->first_name }} {{ $contact->last_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <flux:label class="mb-1">Assignees (multiple)</flux:label>
                        <select name="assignees[]" multiple class="w-full rounded-lg border border-neutral-300 p-2 text-sm dark:border-neutral-600 dark:bg-zinc-800">
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <flux:label class="mb-1">Description</flux:label>
                        <textarea name="description" rows="5" class="w-full rounded-lg border border-neutral-300 p-3 text-sm dark:border-neutral-600 dark:bg-zinc-800">{{ old('description') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <flux:button href="{{ route('crm.deals.index') }}" variant="ghost" wire:navigate>Cancel</flux:button>
                <flux:button type="submit" variant="primary">Save Deal</flux:button>
            </div>
        </form>
    </div>
</x-layouts::app>
