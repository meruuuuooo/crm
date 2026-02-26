<x-layouts::app :title="__('Activities')">
    <div class="flex h-full w-full flex-1 flex-col gap-4">
        <div class="flex items-center justify-between">
            <flux:heading size="xl">Activities</flux:heading>
            <flux:button href="{{ route('crm.activities.create') }}" variant="primary" icon="plus" wire:navigate>Log Activity</flux:button>
        </div>

        @include('modules.crm.partials.flash')

        <div class="overflow-hidden rounded-xl border border-neutral-200 bg-white dark:border-neutral-700 dark:bg-zinc-900">
            <table class="w-full text-sm">
                <thead class="bg-neutral-50 dark:bg-zinc-800">
                    <tr>
                        <th class="px-4 py-3 text-left font-medium text-neutral-600 dark:text-neutral-300">Title</th>
                        <th class="px-4 py-3 text-left font-medium text-neutral-600 dark:text-neutral-300">Type</th>
                        <th class="px-4 py-3 text-left font-medium text-neutral-600 dark:text-neutral-300">Due Date</th>
                        <th class="px-4 py-3 text-left font-medium text-neutral-600 dark:text-neutral-300">Time</th>
                        <th class="px-4 py-3 text-left font-medium text-neutral-600 dark:text-neutral-300">Owner</th>
                        <th class="px-4 py-3 text-left font-medium text-neutral-600 dark:text-neutral-300">Related To</th>
                        <th class="px-4 py-3 text-right font-medium text-neutral-600 dark:text-neutral-300">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-100 dark:divide-neutral-700">
                    @forelse ($activities as $activity)
                        <tr class="hover:bg-neutral-50 dark:hover:bg-zinc-800/50">
                            <td class="px-4 py-3 font-medium">
                                <a href="{{ route('crm.activities.show', $activity) }}" class="text-blue-600 hover:underline">{{ $activity->title }}</a>
                            </td>
                            <td class="px-4 py-3">
                                @php
                                    $typeColors = ['Call'=>'success','Meeting'=>'primary','Email'=>'zinc','Task'=>'warning','Follow Up'=>'secondary','Demo'=>'purple','Other'=>'secondary'];
                                @endphp
                                <flux:badge variant="{{ $typeColors[$activity->activity_type] ?? 'secondary' }}" size="sm">{{ $activity->activity_type ?? '—' }}</flux:badge>
                            </td>
                            <td class="px-4 py-3 text-neutral-600 dark:text-neutral-400">{{ $activity->due_date?->format('M d, Y') ?? '—' }}</td>
                            <td class="px-4 py-3 text-neutral-600 dark:text-neutral-400">{{ $activity->time ?? '—' }}</td>
                            <td class="px-4 py-3 text-neutral-600 dark:text-neutral-400">{{ $activity->owner?->name ?? '—' }}</td>
                            <td class="px-4 py-3 text-neutral-600 dark:text-neutral-400 text-xs">
                                @if($activity->deal) <span class="inline-block">Deal: {{ $activity->deal->deal_name }}</span> @endif
                                @if($activity->contact) <span class="inline-block">Contact: {{ $activity->contact->first_name }}</span> @endif
                                @if($activity->company) <span class="inline-block">Company: {{ $activity->company->company_name }}</span> @endif
                                @if(!$activity->deal && !$activity->contact && !$activity->company) —  @endif
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex justify-end gap-2">
                                    <flux:button href="{{ route('crm.activities.edit', $activity) }}" size="sm" variant="ghost" icon="pencil" wire:navigate />
                                    <form method="POST" action="{{ route('crm.activities.destroy', $activity) }}" onsubmit="return confirm('Delete this activity?')">
                                        @csrf @method('DELETE')
                                        <flux:button type="submit" size="sm" variant="ghost" icon="trash" class="text-red-500" />
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-neutral-400">No activities logged.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div>{{ $activities->links() }}</div>
    </div>
</x-layouts::app>
