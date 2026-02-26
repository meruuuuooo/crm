<x-layouts::app :title="__('Edit Company')">
    <div class="mx-auto max-w-4xl">
        <div class="mb-6 flex items-center gap-3">
            <flux:button href="{{ route('crm.companies.index') }}" variant="ghost" icon="arrow-left" size="sm" wire:navigate />
            <flux:heading size="xl">Edit Company — {{ $company->company_name }}</flux:heading>
        </div>

        @include('modules.crm.partials.flash')

        <form method="POST" action="{{ route('crm.companies.update', $company) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf @method('PUT')

            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
                <flux:heading size="lg" class="mb-4">Basic Information</flux:heading>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

                    <div class="md:col-span-2">
                        <flux:label>Company Files</flux:label>
                        <input type="file" name="company_files" class="mt-1 block w-full text-sm text-neutral-600 file:mr-3 file:rounded-lg file:border-0 file:bg-blue-50 file:px-4 file:py-2 file:text-sm file:font-medium file:text-blue-700 hover:file:bg-blue-100" />
                        @if($company->company_files)
                            <p class="mt-1 text-xs text-neutral-500">Current: {{ basename($company->company_files) }}</p>
                        @endif
                    </div>

                    <flux:input name="company_name" label="Company Name *" value="{{ old('company_name', $company->company_name) }}" required />
                    <flux:input name="email" label="Email" type="email" value="{{ old('email', $company->email) }}" />

                    <div class="flex items-center gap-2 md:col-span-2">
                        <input type="checkbox" id="email_opt_out" name="email_opt_out" value="1" {{ old('email_opt_out', $company->email_opt_out) ? 'checked' : '' }} class="rounded" />
                        <label for="email_opt_out" class="text-sm">Email Opt Out</label>
                    </div>

                    <flux:input name="phone_1" label="Phone 1" value="{{ old('phone_1', $company->phone_1) }}" />
                    <flux:input name="phone_2" label="Phone 2" value="{{ old('phone_2', $company->phone_2) }}" />
                    <flux:input name="fax" label="Fax" value="{{ old('fax', $company->fax) }}" />
                    <flux:input name="website" label="Website" value="{{ old('website', $company->website) }}" />
                    <flux:input name="reviews" label="Reviews" value="{{ old('reviews', $company->reviews) }}" />
                    <flux:input name="tags" label="Tags" value="{{ old('tags', $company->tags) }}" />

                    <flux:select name="owner_id" label="Owner" placeholder="Select Owner">
                        @foreach($users as $user)
                            <flux:select.option value="{{ $user->id }}" :selected="old('owner_id', $company->owner_id) == $user->id">{{ $user->name }}</flux:select.option>
                        @endforeach
                    </flux:select>

                    <flux:select name="source" label="Source" placeholder="Select Source">
                        @foreach(\App\Helpers\CrmOptions::sources() as $src)
                            <flux:select.option value="{{ $src }}" :selected="old('source', $company->source) === $src">{{ $src }}</flux:select.option>
                        @endforeach
                    </flux:select>

                    <flux:select name="industry" label="Industry" placeholder="Select Industry">
                        @foreach(\App\Helpers\CrmOptions::industries() as $ind)
                            <flux:select.option value="{{ $ind }}" :selected="old('industry', $company->industry) === $ind">{{ $ind }}</flux:select.option>
                        @endforeach
                    </flux:select>

                    <flux:select name="currency" label="Currency" placeholder="Select Currency">
                        @foreach(\App\Helpers\CrmOptions::currencies() as $cur)
                            <flux:select.option value="{{ $cur }}" :selected="old('currency', $company->currency) === $cur">{{ $cur }}</flux:select.option>
                        @endforeach
                    </flux:select>

                    <flux:select name="language" label="Language" placeholder="Select Language">
                        @foreach(\App\Helpers\CrmOptions::languages() as $lang)
                            <flux:select.option value="{{ $lang }}" :selected="old('language', $company->language) === $lang">{{ $lang }}</flux:select.option>
                        @endforeach
                    </flux:select>

                    <div class="md:col-span-2">
                        <flux:textarea name="description" label="Description" rows="4">{{ old('description', $company->description) }}</flux:textarea>
                    </div>
                </div>

                @php $model = $company; @endphp
                @include('modules.crm.partials.address-social-access')
            </div>

            <div class="flex justify-end gap-3">
                <flux:button href="{{ route('crm.companies.index') }}" variant="ghost" wire:navigate>Cancel</flux:button>
                <flux:button type="submit" variant="primary">Update Company</flux:button>
            </div>
        </form>
    </div>
</x-layouts::app>
