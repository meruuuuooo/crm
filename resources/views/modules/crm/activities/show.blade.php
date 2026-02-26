<x-layouts::app :title="__('Activity Details')">
    <div class="mx-auto max-w-4xl space-y-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <flux:button href="{{ route('crm.activities.index') }}" variant="ghost" icon="arrow-left" size="sm" wire:navigate />
                <flux:heading size="xl">{{ $activity->title }}</flux:heading>
            </div>
            <div class="flex gap-2">
                <flux:button href="{{ route('crm.activities.edit', $activity) }}" variant="primary" icon="pencil" wire:navigate>Edit</flux:button>
                <form method="POST" action="{{ route('crm.activities.destroy', $activity) }}" onsubmit="return confirm('Delete this activity?')">
                    @csrf @method('DELETE')
                    <flux:button type="submit" variant="danger" icon="trash">Delete</flux:button>
                </form>
            </div>
        </div>

        @include('modules.crm.partials.flash')

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <div class="space-y-6 lg:col-span-2">
                <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
                    <flux:heading size="lg" class="mb-4">Activity Details</flux:heading>
                    <dl class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <dt class="font-medium text-neutral-500">Type</dt>
                            <dd class="mt-1">
                                @php $typeColors = ['Call'=>'success','Meeting'=>'primary','Email'=>'zinc','Task'=>'warning','Follow Up'=>'secondary','Demo'=>'purple','Other'=>'secondary']; @endphp
                                <flux:badge variant="{{ $typeColors[$activity->activity_type] ?? 'secondary' }}" size="sm">{{ $activity->activity_type ?? '—' }}</flux:badge>
                            </dd>
                        </div>
                        <div>
                            <dt class="font-medium text-neutral-500">Owner</dt>
                            <dd class="mt-1">{{ $activity->owner?->name ?? '—' }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-neutral-500">Due Date</dt>
                            <dd class="mt-1">{{ $activity->due_date?->format('M d, Y') ?? '—' }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-neutral-500">Time</dt>
                            <dd class="mt-1">{{ $activity->time ?? '—' }}</dd>
                        </div>
                        @if($activity->reminder_value)
                            <div>
                                <dt class="font-medium text-neutral-500">Reminder</dt>
                                <dd class="mt-1">{{ $activity->reminder_value }} {{ $activity->reminder_unit }}</dd>
                            </div>
                        @endif
                    </dl>
                    @if($activity->description)
                        <div class="mt-4 border-t border-neutral-100 pt-4 dark:border-neutral-700">
                            <dt class="mb-1 font-medium text-neutral-500 text-sm">Description</dt>
                            <dd class="text-sm text-neutral-700 dark:text-neutral-300">{{ $activity->description }}</dd>
                        </div>
                    @endif
                </div>

                {{-- Related Records --}}
                @if($activity->deal || $activity->contact || $activity->company)
                    <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
                        <flux:heading size="lg" class="mb-4">Related Records</flux:heading>
                        <dl class="grid grid-cols-1 gap-3 text-sm md:grid-cols-3">
                            @if($activity->deal)
                                <div>
                                    <dt class="font-medium text-neutral-500">Deal</dt>
                                    <dd class="mt-1">
                                        <a href="{{ route('crm.deals.show', $activity->deal) }}" class="text-blue-600 hover:underline">{{ $activity->deal->deal_name }}</a>
                                    </dd>
                                </div>
                            @endif
                            @if($activity->contact)
                                <div>
                                    <dt class="font-medium text-neutral-500">Contact</dt>
                                    <dd class="mt-1">
                                        <a href="{{ route('crm.contacts.show', $activity->contact) }}" class="text-blue-600 hover:underline">{{ $activity->contact->first_name }} {{ $activity->contact->last_name }}</a>
                                    </dd>
                                </div>
                            @endif
                            @if($activity->company)
                                <div>
                                    <dt class="font-medium text-neutral-500">Company</dt>
                                    <dd class="mt-1">
                                        <a href="{{ route('crm.companies.show', $activity->company) }}" class="text-blue-600 hover:underline">{{ $activity->company->company_name }}</a>
                                    </dd>
                                </div>
                            @endif
                        </dl>
                    </div>
                @endif
            </div>

            <div class="space-y-6">
                <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
                    <flux:heading size="md" class="mb-3">Guests</flux:heading>
                    @forelse($activity->guests as $guest)
                        <div class="flex items-center gap-2 py-1 text-sm">
                            <div class="h-7 w-7 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-medium text-xs">
                                {{ strtoupper(substr($guest->name, 0, 1)) }}
                            </div>
                            {{ $guest->name }}
                        </div>
                    @empty
                        <p class="text-sm text-neutral-400">No guests</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-layouts::app>
