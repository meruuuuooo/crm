<x-layouts::app :title="__('Add Proposal')">
    <div class="mx-auto max-w-4xl">
        <div class="mb-6 flex items-center gap-3">
            <flux:button href="{{ route('crm.proposals.index') }}" variant="ghost" icon="arrow-left" size="sm" wire:navigate />
            <flux:heading size="xl">Add Proposal</flux:heading>
        </div>

        @include('modules.crm.partials.flash')

        <form method="POST" action="{{ route('crm.proposals.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
                <flux:heading size="lg" class="mb-4">Proposal Details</flux:heading>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <flux:input name="subject" label="Subject *" value="{{ old('subject') }}" required class="md:col-span-2" />
                    <flux:input name="date" label="Date" type="date" value="{{ old('date') }}" />
                    <flux:input name="open_till" label="Open Till" type="date" value="{{ old('open_till') }}" />
                    <flux:select name="client_id" label="Client" placeholder="Select Client">
                        @foreach($contacts as $c)
                            <flux:select.option value="{{ $c->id }}" :selected="old('client_id') == $c->id">{{ $c->first_name }} {{ $c->last_name }}</flux:select.option>
                        @endforeach
                    </flux:select>
                    <flux:select name="project_id" label="Project" placeholder="Select Project">
                        @foreach($projects as $p)
                            <flux:select.option value="{{ $p->id }}" :selected="old('project_id') == $p->id">{{ $p->name }}</flux:select.option>
                        @endforeach
                    </flux:select>
                    <flux:input name="related_to" label="Related To" value="{{ old('related_to') }}" placeholder="e.g. Deal name, Campaign" />
                    <flux:select name="deal_id" label="Related Deal" placeholder="Select Deal">
                        @foreach($deals as $d)
                            <flux:select.option value="{{ $d->id }}" :selected="old('deal_id') == $d->id">{{ $d->deal_name }}</flux:select.option>
                        @endforeach
                    </flux:select>
                    <flux:select name="currency" label="Currency" placeholder="Select Currency">
                        @foreach(\App\Helpers\CrmOptions::currencies() as $cur)
                            <flux:select.option value="{{ $cur }}" :selected="old('currency') === $cur">{{ $cur }}</flux:select.option>
                        @endforeach
                    </flux:select>
                    <flux:select name="status" label="Status" placeholder="Select Status">
                        @foreach(\App\Helpers\CrmOptions::proposalStatuses() as $s)
                            <flux:select.option value="{{ $s }}" :selected="old('status') === $s">{{ $s }}</flux:select.option>
                        @endforeach
                    </flux:select>
                    <flux:input name="tags" label="Tags" value="{{ old('tags') }}" placeholder="e.g. urgent, Q4" />
                    <div>
                        <flux:label>Attachment</flux:label>
                        <input type="file" name="attachment" class="mt-1 block w-full text-sm text-neutral-600 file:mr-3 file:rounded-lg file:border-0 file:bg-blue-50 file:px-4 file:py-2 file:text-sm file:font-medium file:text-blue-700 hover:file:bg-blue-100" />
                    </div>
                    <div class="md:col-span-2">
                        <flux:textarea name="description" label="Description" rows="4">{{ old('description') }}</flux:textarea>
                    </div>
                </div>
            </div>

            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
                <flux:heading size="lg" class="mb-4">Assignees</flux:heading>
                <select name="assignees[]" multiple class="block w-full rounded-lg border border-neutral-300 bg-white px-3 py-2 text-sm focus:border-blue-500 focus:outline-none dark:border-neutral-600 dark:bg-zinc-800 dark:text-white">
                    @foreach($users as $u)
                        <option value="{{ $u->id }}" {{ in_array($u->id, old('assignees', [])) ? 'selected' : '' }}>{{ $u->name }}</option>
                    @endforeach
                </select>
                <p class="mt-1 text-xs text-neutral-400">Hold Ctrl/Cmd to select multiple</p>
            </div>

            <div class="flex justify-end gap-3">
                <flux:button href="{{ route('crm.proposals.index') }}" variant="ghost" wire:navigate>Cancel</flux:button>
                <flux:button type="submit" variant="primary">Save Proposal</flux:button>
            </div>
        </form>
    </div>
</x-layouts::app>
