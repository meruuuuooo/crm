<x-layouts::app :title="$company->company_name">
    <div class="mx-auto max-w-4xl space-y-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <flux:button href="{{ route('crm.companies.index') }}" variant="ghost" icon="arrow-left" size="sm" wire:navigate />
                <flux:heading size="xl">{{ $company->company_name }}</flux:heading>
                <flux:badge :variant="$company->visibility === 'public' ? 'success' : 'warning'" size="sm">{{ ucfirst($company->visibility) }}</flux:badge>
            </div>
            <flux:button href="{{ route('crm.companies.edit', $company) }}" variant="primary" icon="pencil" size="sm" wire:navigate>Edit</flux:button>
        </div>

        <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
            {{-- Main Info --}}
            <div class="md:col-span-2 space-y-4 rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
                <flux:heading size="lg">Basic Information</flux:heading>
                <dl class="grid grid-cols-2 gap-x-4 gap-y-3 text-sm">
                    <dt class="font-medium text-neutral-500">Email</dt><dd>{{ $company->email ?? '—' }}</dd>
                    <dt class="font-medium text-neutral-500">Phone 1</dt><dd>{{ $company->phone_1 ?? '—' }}</dd>
                    <dt class="font-medium text-neutral-500">Phone 2</dt><dd>{{ $company->phone_2 ?? '—' }}</dd>
                    <dt class="font-medium text-neutral-500">Fax</dt><dd>{{ $company->fax ?? '—' }}</dd>
                    <dt class="font-medium text-neutral-500">Website</dt><dd>{{ $company->website ? '<a href="'.$company->website.'" target="_blank" class="text-blue-600 hover:underline">'.$company->website.'</a>' : '—' }}</dd>
                    <dt class="font-medium text-neutral-500">Industry</dt><dd>{{ $company->industry ?? '—' }}</dd>
                    <dt class="font-medium text-neutral-500">Source</dt><dd>{{ $company->source ?? '—' }}</dd>
                    <dt class="font-medium text-neutral-500">Currency</dt><dd>{{ $company->currency ?? '—' }}</dd>
                    <dt class="font-medium text-neutral-500">Language</dt><dd>{{ $company->language ?? '—' }}</dd>
                    <dt class="font-medium text-neutral-500">Tags</dt><dd>{{ $company->tags ?? '—' }}</dd>
                    <dt class="font-medium text-neutral-500">Owner</dt><dd>{{ $company->owner?->name ?? '—' }}</dd>
                </dl>

                @if($company->description)
                    <div class="mt-4 border-t pt-4 dark:border-neutral-700">
                        <p class="text-sm font-medium text-neutral-500 mb-1">Description</p>
                        <p class="text-sm">{{ $company->description }}</p>
                    </div>
                @endif
            </div>

            {{-- Sidebar --}}
            <div class="space-y-4">
                <div class="rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-zinc-900">
                    <flux:heading size="sm" class="mb-3">Address</flux:heading>
                    <p class="text-sm text-neutral-600 dark:text-neutral-400">
                        {{ $company->street_address ?? '' }}<br>
                        {{ implode(', ', array_filter([$company->city, $company->state, $company->zipcode])) }}<br>
                        {{ $company->country ?? '' }}
                    </p>
                </div>

                <div class="rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-zinc-900">
                    <flux:heading size="sm" class="mb-3">Social</flux:heading>
                    <div class="space-y-1 text-sm">
                        @foreach(['facebook','linkedin','twitter','instagram','skype','whatsapp'] as $social)
                            @if($company->$social)
                                <p><span class="font-medium capitalize">{{ $social }}:</span> {{ $company->$social }}</p>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Contacts Tab --}}
        <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
            <flux:heading size="lg" class="mb-3">Contacts ({{ $company->contacts->count() }})</flux:heading>
            @forelse($company->contacts as $contact)
                <div class="flex items-center justify-between py-2 border-b last:border-0 dark:border-neutral-700">
                    <a href="{{ route('crm.contacts.show', $contact) }}" class="text-sm text-blue-600 hover:underline">
                        {{ $contact->first_name }} {{ $contact->last_name }}
                    </a>
                    <span class="text-xs text-neutral-400">{{ $contact->job_title }}</span>
                </div>
            @empty
                <p class="text-sm text-neutral-400">No contacts linked.</p>
            @endforelse
        </div>
    </div>
</x-layouts::app>
