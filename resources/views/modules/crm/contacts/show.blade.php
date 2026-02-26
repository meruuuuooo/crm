<x-layouts::app :title="$contact->first_name . ' ' . $contact->last_name">
    <div class="mx-auto max-w-4xl space-y-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <flux:button href="{{ route('crm.contacts.index') }}" variant="ghost" icon="arrow-left" size="sm" wire:navigate />
                @if($contact->profile_image)
                    <img src="{{ asset('storage/'.$contact->profile_image) }}" class="h-10 w-10 rounded-full object-cover" />
                @endif
                <div>
                    <flux:heading size="xl">{{ $contact->first_name }} {{ $contact->last_name }}</flux:heading>
                    <p class="text-sm text-neutral-400">{{ $contact->job_title }}</p>
                </div>
            </div>
            <flux:button href="{{ route('crm.contacts.edit', $contact) }}" variant="primary" icon="pencil" size="sm" wire:navigate>Edit</flux:button>
        </div>

        <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
            <div class="md:col-span-2 space-y-4 rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
                <flux:heading size="lg">Basic Information</flux:heading>
                <dl class="grid grid-cols-2 gap-x-4 gap-y-3 text-sm">
                    <dt class="font-medium text-neutral-500">Company</dt><dd>{{ $contact->company?->company_name ?? '—' }}</dd>
                    <dt class="font-medium text-neutral-500">Email</dt><dd>{{ $contact->email ?? '—' }}</dd>
                    <dt class="font-medium text-neutral-500">Phone 1</dt><dd>{{ $contact->phone_1 ?? '—' }}</dd>
                    <dt class="font-medium text-neutral-500">Phone 2</dt><dd>{{ $contact->phone_2 ?? '—' }}</dd>
                    <dt class="font-medium text-neutral-500">Fax</dt><dd>{{ $contact->fax ?? '—' }}</dd>
                    <dt class="font-medium text-neutral-500">Date of Birth</dt><dd>{{ $contact->date_of_birth?->format('M d, Y') ?? '—' }}</dd>
                    <dt class="font-medium text-neutral-500">Industry</dt><dd>{{ $contact->industry ?? '—' }}</dd>
                    <dt class="font-medium text-neutral-500">Source</dt><dd>{{ $contact->source ?? '—' }}</dd>
                    <dt class="font-medium text-neutral-500">Currency</dt><dd>{{ $contact->currency ?? '—' }}</dd>
                    <dt class="font-medium text-neutral-500">Language</dt><dd>{{ $contact->language ?? '—' }}</dd>
                    <dt class="font-medium text-neutral-500">Owner</dt><dd>{{ $contact->owner?->name ?? '—' }}</dd>
                    <dt class="font-medium text-neutral-500">Tags</dt><dd>{{ $contact->tags ?? '—' }}</dd>
                    <dt class="font-medium text-neutral-500">Visibility</dt><dd><flux:badge size="sm">{{ ucfirst($contact->visibility) }}</flux:badge></dd>
                </dl>
                @if($contact->description)
                    <div class="border-t pt-4 dark:border-neutral-700">
                        <p class="text-sm font-medium text-neutral-500 mb-1">Description</p>
                        <p class="text-sm">{{ $contact->description }}</p>
                    </div>
                @endif
            </div>
            <div class="space-y-4">
                <div class="rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-zinc-900">
                    <flux:heading size="sm" class="mb-3">Address</flux:heading>
                    <p class="text-sm text-neutral-600 dark:text-neutral-400">
                        {{ $contact->street_address ?? '' }}<br>
                        {{ implode(', ', array_filter([$contact->city, $contact->state, $contact->zipcode])) }}<br>
                        {{ $contact->country ?? '' }}
                    </p>
                </div>
                <div class="rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-zinc-900">
                    <flux:heading size="sm" class="mb-3">Social</flux:heading>
                    <div class="space-y-1 text-sm">
                        @foreach(['facebook','linkedin','twitter','instagram','skype','whatsapp'] as $social)
                            @if($contact->$social)
                                <p><span class="font-medium capitalize">{{ $social }}:</span> {{ $contact->$social }}</p>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
            <flux:heading size="lg" class="mb-3">Deals ({{ $contact->deals->count() }})</flux:heading>
            @forelse($contact->deals as $deal)
                <div class="flex items-center justify-between py-2 border-b last:border-0 dark:border-neutral-700">
                    <a href="{{ route('crm.deals.show', $deal) }}" class="text-sm text-blue-600 hover:underline">{{ $deal->deal_name }}</a>
                    <flux:badge size="sm">{{ $deal->status }}</flux:badge>
                </div>
            @empty
                <p class="text-sm text-neutral-400">No deals linked.</p>
            @endforelse
        </div>
    </div>
</x-layouts::app>
