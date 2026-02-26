<x-layouts::app :title="__('Edit Proposal')">
    <div class="mx-auto max-w-4xl">
        <div class="mb-6 flex items-center gap-3">
            <flux:button href="{{ route('crm.proposals.show', $proposal) }}" variant="ghost" icon="arrow-left" size="sm" wire:navigate />
            <flux:heading size="xl">Edit Proposal</flux:heading>
        </div>

        @include('modules.crm.partials.flash')

        <form method="POST" action="{{ route('crm.proposals.update', $proposal) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf @method('PUT')

            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
                <flux:heading size="lg" class="mb-4">Proposal Details</flux:heading>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <flux:input name="subject" label="Subject *" value="{{ old('subject', $proposal->subject) }}" required class="md:col-span-2" />
                    <flux:input name="date" label="Date" type="date" value="{{ old('date', $proposal->date?->format('Y-m-d')) }}" />
                    <flux:input name="open_till" label="Open Till" type="date" value="{{ old('open_till', $proposal->open_till?->format('Y-m-d')) }}" />
                    <flux:select name="client_id" label="Client" placeholder="Select Client">
                        @foreach($contacts as $c)
                            <flux:select.option value="{{ $c->id }}" :selected="old('client_id', $proposal->client_id) == $c->id">{{ $c->first_name }} {{ $c->last_name }}</flux:select.option>
                        @endforeach
                    </flux:select>
                    <flux:select name="project_id" label="Project" placeholder="Select Project">
                        @foreach($projects as $p)
                            <flux:select.option value="{{ $p->id }}" :selected="old('project_id', $proposal->project_id) == $p->id">{{ $p->name }}</flux:select.option>
                        @endforeach
                    </flux:select>
                    <flux:input name="related_to" label="Related To" value="{{ old('related_to', $proposal->related_to) }}" />
                    <flux:select name="deal_id" label="Related Deal" placeholder="Select Deal">
                        @foreach($deals as $d)
                            <flux:select.option value="{{ $d->id }}" :selected="old('deal_id', $proposal->deal_id) == $d->id">{{ $d->deal_name }}</flux:select.option>
                        @endforeach
                    </flux:select>
                    <flux:select name="currency" label="Currency" placeholder="Select Currency">
                        @foreach(\App\Helpers\CrmOptions::currencies() as $cur)
                            <flux:select.option value="{{ $cur }}" :selected="old('currency', $proposal->currency) === $cur">{{ $cur }}</flux:select.option>
                        @endforeach
                    </flux:select>
                    <flux:select name="status" label="Status" placeholder="Select Status">
                        @foreach(\App\Helpers\CrmOptions::proposalStatuses() as $s)
                            <flux:select.option value="{{ $s }}" :selected="old('status', $proposal->status) === $s">{{ $s }}</flux:select.option>
                        @endforeach
                    </flux:select>
                    <flux:input name="tags" label="Tags" value="{{ old('tags', $proposal->tags) }}" />
                    <div>
                        <flux:label>Attachment</flux:label>
                        @if($proposal->attachment)
                            <p class="mb-1 text-xs text-neutral-500">Current: {{ basename($proposal->attachment) }}</p>
                        @endif
                        <input type="file" name="attachment" class="mt-1 block w-full text-sm text-neutral-600 file:mr-3 file:rounded-lg file:border-0 file:bg-blue-50 file:px-4 file:py-2 file:text-sm file:font-medium file:text-blue-700 hover:file:bg-blue-100" />
                    </div>
                    <div class="md:col-span-2">
                        <flux:textarea name="description" label="Description" rows="4">{{ old('description', $proposal->description) }}</flux:textarea>
                    </div>
                </div>
            </div>

            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
                <flux:heading size="lg" class="mb-4">Assignees</flux:heading>
                <select name="assignees[]" multiple class="block w-full rounded-lg border border-neutral-300 bg-white px-3 py-2 text-sm focus:border-blue-500 focus:outline-none dark:border-neutral-600 dark:bg-zinc-800 dark:text-white">
                    @foreach($users as $u)
                        <option value="{{ $u->id }}" {{ in_array($u->id, old('assignees', $proposal->assignees->pluck('id')->toArray())) ? 'selected' : '' }}>{{ $u->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-end gap-3">
                <flux:button href="{{ route('crm.proposals.show', $proposal) }}" variant="ghost" wire:navigate>Cancel</flux:button>
                <flux:button type="submit" variant="primary">Update Proposal</flux:button>
            </div>
        </form>
    </div>
</x-layouts::app>
