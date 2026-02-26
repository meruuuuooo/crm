<x-layouts::app :title="__('Add Lead')">
    <div class="mx-auto max-w-4xl">
        <div class="mb-6 flex items-center gap-3">
            <flux:button href="{{ route('crm.leads.index') }}" variant="ghost" icon="arrow-left" size="sm" wire:navigate />
            <flux:heading size="xl">Add Lead</flux:heading>
        </div>
        @include('modules.crm.partials.flash')
        <form method="POST" action="{{ route('crm.leads.store') }}" class="space-y-6">
            @csrf
            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
                <flux:heading size="lg" class="mb-4">Basic Information</flux:heading>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <flux:input name="lead_name" label="Lead Name *" value="{{ old('lead_name') }}" required class="md:col-span-2" />

                    <div class="md:col-span-2">
                        <flux:label>Lead Type</flux:label>
                        <div class="mt-2 flex gap-6">
                            @foreach(['individual' => 'Individual', 'company' => 'Company'] as $val => $label)
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="lead_type" value="{{ $val }}" {{ old('lead_type', 'individual') === $val ? 'checked' : '' }} class="text-blue-600" />
                                    <span class="text-sm">{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <flux:select name="company_id" label="Company Name" placeholder="Select Company">
                        @foreach($companies as $company)
                            <flux:select.option value="{{ $company->id }}" :selected="old('company_id') == $company->id">{{ $company->company_name }}</flux:select.option>
                        @endforeach
                    </flux:select>

                    <flux:input name="value" label="Value" type="number" step="0.01" value="{{ old('value') }}" />

                    <flux:select name="currency" label="Currency" placeholder="Select Currency">
                        @foreach(\App\Helpers\CrmOptions::currencies() as $cur)
                            <flux:select.option value="{{ $cur }}" :selected="old('currency') === $cur">{{ $cur }}</flux:select.option>
                        @endforeach
                    </flux:select>

                    <flux:input name="phone" label="Phone" value="{{ old('phone') }}" />

                    <flux:select name="phone_type" label="Phone Type" placeholder="Select Type">
                        <flux:select.option value="Work" :selected="old('phone_type') === 'Work'">Work</flux:select.option>
                        <flux:select.option value="Home" :selected="old('phone_type') === 'Home'">Home</flux:select.option>
                    </flux:select>

                    <flux:select name="source" label="Source" placeholder="Select Source">
                        @foreach(\App\Helpers\CrmOptions::sources() as $src)
                            <flux:select.option value="{{ $src }}" :selected="old('source') === $src">{{ $src }}</flux:select.option>
                        @endforeach
                    </flux:select>

                    <flux:select name="industry" label="Industry" placeholder="Select Industry">
                        @foreach(\App\Helpers\CrmOptions::industries() as $ind)
                            <flux:select.option value="{{ $ind }}" :selected="old('industry') === $ind">{{ $ind }}</flux:select.option>
                        @endforeach
                    </flux:select>

                    <flux:input name="tags" label="Tags" value="{{ old('tags') }}" placeholder="Comma-separated tags" />

                    <div class="md:col-span-2">
                        <flux:label class="mb-1">Owner (multiple)</flux:label>
                        <select name="owners[]" multiple class="w-full rounded-lg border border-neutral-300 p-2 text-sm dark:border-neutral-600 dark:bg-zinc-800">
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <flux:textarea name="description" label="Description" rows="4">{{ old('description') }}</flux:textarea>
                    </div>
                </div>

                {{-- Access Settings --}}
                <div class="mt-6">
                    <flux:separator text="Access Settings" />
                    <div class="mt-4">
                        <flux:label>Visibility</flux:label>
                        <div class="mt-2 flex gap-6">
                            @foreach(['public' => 'Public', 'private' => 'Private', 'team' => 'Team'] as $val => $label)
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="visibility" value="{{ $val }}" {{ old('visibility', 'public') === $val ? 'checked' : '' }} class="text-blue-600" />
                                    <span class="text-sm">{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex justify-end gap-3">
                <flux:button href="{{ route('crm.leads.index') }}" variant="ghost" wire:navigate>Cancel</flux:button>
                <flux:button type="submit" variant="primary">Save Lead</flux:button>
            </div>
        </form>
    </div>
</x-layouts::app>
