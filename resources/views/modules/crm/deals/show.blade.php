<x-layouts::app :title="$deal->deal_name">
    <div class="mx-auto max-w-4xl space-y-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <flux:button href="{{ route('crm.deals.index') }}" variant="ghost" icon="arrow-left" size="sm" wire:navigate />
                <flux:heading size="xl">{{ $deal->deal_name }}</flux:heading>
                <flux:badge size="sm">{{ $deal->status ?? '—' }}</flux:badge>
            </div>
            <flux:button href="{{ route('crm.deals.edit', $deal) }}" variant="primary" icon="pencil" size="sm" wire:navigate>Edit</flux:button>
        </div>

        <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
            <div class="md:col-span-2 rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
                <flux:heading size="lg" class="mb-4">Deal Details</flux:heading>
                <dl class="grid grid-cols-2 gap-x-4 gap-y-3 text-sm">
                    <dt class="font-medium text-neutral-500">Pipeline</dt><dd>{{ $deal->pipeline?->name ?? '—' }}</dd>
                    <dt class="font-medium text-neutral-500">Value</dt><dd>{{ $deal->currency }} {{ number_format($deal->deal_value ?? 0, 2) }}</dd>
                    <dt class="font-medium text-neutral-500">Priority</dt><dd>{{ $deal->priority ?? '—' }}</dd>
                    <dt class="font-medium text-neutral-500">Period</dt><dd>{{ $deal->period ?? '—' }}</dd>
                    <dt class="font-medium text-neutral-500">Due Date</dt><dd>{{ $deal->due_date?->format('M d, Y') ?? '—' }}</dd>
                    <dt class="font-medium text-neutral-500">Closing Date</dt><dd>{{ $deal->expected_closing_date?->format('M d, Y') ?? '—' }}</dd>
                    <dt class="font-medium text-neutral-500">Follow Up</dt><dd>{{ $deal->follow_up_date?->format('M d, Y') ?? '—' }}</dd>
                    <dt class="font-medium text-neutral-500">Source</dt><dd>{{ $deal->source ?? '—' }}</dd>
                    <dt class="font-medium text-neutral-500">Tags</dt><dd>{{ $deal->tags ?? '—' }}</dd>
                </dl>
                @if($deal->description)
                    <div class="mt-4 border-t pt-4 dark:border-neutral-700">
                        <p class="text-sm font-medium text-neutral-500 mb-1">Description</p>
                        <div class="text-sm prose dark:prose-invert max-w-none">{!! $deal->description !!}</div>
                    </div>
                @endif
            </div>
            <div class="space-y-4">
                <div class="rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-zinc-900">
                    <flux:heading size="sm" class="mb-3">Contacts</flux:heading>
                    @forelse($deal->contacts as $contact)
                        <a href="{{ route('crm.contacts.show', $contact) }}" class="block text-sm text-blue-600 hover:underline py-1">
                            {{ $contact->first_name }} {{ $contact->last_name }}
                        </a>
                    @empty
                        <p class="text-sm text-neutral-400">None</p>
                    @endforelse
                </div>
                <div class="rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-zinc-900">
                    <flux:heading size="sm" class="mb-3">Assignees</flux:heading>
                    @forelse($deal->assignees as $user)
                        <p class="text-sm py-1">{{ $user->name }}</p>
                    @empty
                        <p class="text-sm text-neutral-400">None</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-layouts::app>
