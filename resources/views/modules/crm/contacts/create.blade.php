<x-layouts::app :title="__('Add Contact')">
    <div class="mx-auto max-w-4xl">
        <div class="mb-6 flex items-center gap-3">
            <flux:button href="{{ route('crm.contacts.index') }}" variant="ghost" icon="arrow-left" size="sm" wire:navigate />
            <flux:heading size="xl">Add Contact</flux:heading>
        </div>

        @include('modules.crm.partials.flash')

        <form method="POST" action="{{ route('crm.contacts.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
                <flux:heading size="lg" class="mb-4">Basic Information</flux:heading>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

                    <div class="md:col-span-2">
                        <flux:label>Profile Image</flux:label>
                        <input type="file" name="profile_image" accept="image/*" class="mt-1 block w-full text-sm text-neutral-600 file:mr-3 file:rounded-lg file:border-0 file:bg-blue-50 file:px-4 file:py-2 file:text-sm file:font-medium file:text-blue-700 hover:file:bg-blue-100" />
                    </div>

                    <flux:input name="first_name" label="First Name *" value="{{ old('first_name') }}" required />
                    <flux:input name="last_name" label="Last Name *" value="{{ old('last_name') }}" required />
                    <flux:input name="job_title" label="Job Title" value="{{ old('job_title') }}" />

                    <flux:select name="company_id" label="Company Name" placeholder="Select Company">
                        @foreach($companies as $company)
                            <flux:select.option value="{{ $company->id }}" :selected="old('company_id') == $company->id">{{ $company->company_name }}</flux:select.option>
                        @endforeach
                    </flux:select>

                    <flux:input name="email" label="Email" type="email" value="{{ old('email') }}" />

                    <div class="flex items-center gap-2 md:col-span-2">
                        <input type="checkbox" id="email_opt_out" name="email_opt_out" value="1" {{ old('email_opt_out') ? 'checked' : '' }} class="rounded" />
                        <label for="email_opt_out" class="text-sm">Email Opt Out</label>
                    </div>

                    <flux:input name="phone_1" label="Phone 1" value="{{ old('phone_1') }}" />
                    <flux:input name="phone_2" label="Phone 2" value="{{ old('phone_2') }}" />
                    <flux:input name="fax" label="Fax" value="{{ old('fax') }}" />
                    <flux:input name="date_of_birth" label="Date of Birth" type="date" value="{{ old('date_of_birth') }}" />
                    <flux:input name="reviews" label="Reviews" value="{{ old('reviews') }}" />
                    <flux:input name="tags" label="Tags" value="{{ old('tags') }}" placeholder="Comma-separated tags" />

                    <flux:select name="owner_id" label="Owner" placeholder="Select Owner">
                        @foreach($users as $user)
                            <flux:select.option value="{{ $user->id }}" :selected="old('owner_id') == $user->id">{{ $user->name }}</flux:select.option>
                        @endforeach
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

                    <flux:select name="currency" label="Currency" placeholder="Select Currency">
                        @foreach(\App\Helpers\CrmOptions::currencies() as $cur)
                            <flux:select.option value="{{ $cur }}" :selected="old('currency') === $cur">{{ $cur }}</flux:select.option>
                        @endforeach
                    </flux:select>

                    <flux:select name="language" label="Language" placeholder="Select Language">
                        @foreach(\App\Helpers\CrmOptions::languages() as $lang)
                            <flux:select.option value="{{ $lang }}" :selected="old('language') === $lang">{{ $lang }}</flux:select.option>
                        @endforeach
                    </flux:select>

                    <div class="md:col-span-2">
                        <flux:label class="mb-1">Deals</flux:label>
                        <select name="deals[]" multiple class="w-full rounded-lg border border-neutral-300 p-2 text-sm dark:border-neutral-600 dark:bg-zinc-800">
                            @foreach($deals as $deal)
                                <option value="{{ $deal->id }}">{{ $deal->deal_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <flux:textarea name="description" label="Description" rows="4">{{ old('description') }}</flux:textarea>
                    </div>
                </div>

                @php $model = null; @endphp
                @include('modules.crm.partials.address-social-access')
            </div>

            <div class="flex justify-end gap-3">
                <flux:button href="{{ route('crm.contacts.index') }}" variant="ghost" wire:navigate>Cancel</flux:button>
                <flux:button type="submit" variant="primary">Save Contact</flux:button>
            </div>
        </form>
    </div>
</x-layouts::app>
