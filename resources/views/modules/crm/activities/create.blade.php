<x-layouts::app :title="__('Log Activity')">
    <div class="mx-auto max-w-4xl">
        <div class="mb-6 flex items-center gap-3">
            <flux:button href="{{ route('crm.activities.index') }}" variant="ghost" icon="arrow-left" size="sm" wire:navigate />
            <flux:heading size="xl">Log Activity</flux:heading>
        </div>

        @include('modules.crm.partials.flash')

        <form method="POST" action="{{ route('crm.activities.store') }}" class="space-y-6">
            @csrf

            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
                <flux:heading size="lg" class="mb-4">Activity Details</flux:heading>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <flux:input name="title" label="Title *" value="{{ old('title') }}" required class="md:col-span-2" />
                    <flux:select name="activity_type" label="Activity Type *" placeholder="Select Type">
                        @foreach(\App\Helpers\CrmOptions::activityTypes() as $t)
                            <flux:select.option value="{{ $t }}" :selected="old('activity_type') === $t">{{ $t }}</flux:select.option>
                        @endforeach
                    </flux:select>
                    <flux:input name="due_date" label="Due Date" type="date" value="{{ old('due_date') }}" />
                    <flux:input name="time" label="Time" type="time" value="{{ old('time') }}" />
                    <flux:select name="owner_id" label="Owner" placeholder="Select Owner">
                        @foreach($users as $u)
                            <flux:select.option value="{{ $u->id }}" :selected="old('owner_id') == $u->id">{{ $u->name }}</flux:select.option>
                        @endforeach
                    </flux:select>
                    <flux:input name="reminder_value" label="Reminder (value)" type="number" min="0" value="{{ old('reminder_value') }}" />
                    <flux:select name="reminder_unit" label="Reminder (unit)" placeholder="Select Unit">
                        @foreach(['Minutes','Hours','Days'] as $unit)
                            <flux:select.option value="{{ $unit }}" :selected="old('reminder_unit') === $unit">{{ $unit }}</flux:select.option>
                        @endforeach
                    </flux:select>
                    <div class="md:col-span-2">
                        <flux:textarea name="description" label="Description" rows="4">{{ old('description') }}</flux:textarea>
                    </div>
                </div>
            </div>

            {{-- Related Records --}}
            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
                <flux:heading size="lg" class="mb-4">Related Records</flux:heading>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                    <flux:select name="deal_id" label="Deal" placeholder="Select Deal">
                        @foreach($deals as $d)
                            <flux:select.option value="{{ $d->id }}" :selected="old('deal_id') == $d->id">{{ $d->deal_name }}</flux:select.option>
                        @endforeach
                    </flux:select>
                    <flux:select name="contact_id" label="Contact" placeholder="Select Contact">
                        @foreach($contacts as $c)
                            <flux:select.option value="{{ $c->id }}" :selected="old('contact_id') == $c->id">{{ $c->first_name }} {{ $c->last_name }}</flux:select.option>
                        @endforeach
                    </flux:select>
                    <flux:select name="company_id" label="Company" placeholder="Select Company">
                        @foreach($companies as $co)
                            <flux:select.option value="{{ $co->id }}" :selected="old('company_id') == $co->id">{{ $co->company_name }}</flux:select.option>
                        @endforeach
                    </flux:select>
                </div>
            </div>

            {{-- Guests --}}
            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
                <flux:heading size="lg" class="mb-4">Guests</flux:heading>
                <select name="guests[]" multiple class="block w-full rounded-lg border border-neutral-300 bg-white px-3 py-2 text-sm focus:border-blue-500 focus:outline-none dark:border-neutral-600 dark:bg-zinc-800 dark:text-white">
                    @foreach($users as $u)
                        <option value="{{ $u->id }}" {{ in_array($u->id, old('guests', [])) ? 'selected' : '' }}>{{ $u->name }}</option>
                    @endforeach
                </select>
                <p class="mt-1 text-xs text-neutral-400">Hold Ctrl/Cmd to select multiple</p>
            </div>

            <div class="flex justify-end gap-3">
                <flux:button href="{{ route('crm.activities.index') }}" variant="ghost" wire:navigate>Cancel</flux:button>
                <flux:button type="submit" variant="primary">Save Activity</flux:button>
            </div>
        </form>
    </div>
</x-layouts::app>
