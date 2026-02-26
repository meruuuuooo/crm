<x-layouts::app :title="$lead->lead_name">
    <div class="mx-auto max-w-4xl space-y-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <flux:button href="{{ route('crm.leads.index') }}" variant="ghost" icon="arrow-left" size="sm" wire:navigate />
                <flux:heading size="xl">{{ $lead->lead_name }}</flux:heading>
                <flux:badge size="sm">{{ ucfirst($lead->lead_type) }}</flux:badge>
            </div>
            <flux:button href="{{ route('crm.leads.edit', $lead) }}" variant="primary" icon="pencil" size="sm" wire:navigate>Edit</flux:button>
        </div>
        <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
            <dl class="grid grid-cols-2 gap-x-4 gap-y-3 text-sm">
                <dt class="font-medium text-neutral-500">Company</dt><dd>{{ $lead->company?->company_name ?? '—' }}</dd>
                <dt class="font-medium text-neutral-500">Value</dt><dd>{{ $lead->currency }} {{ number_format($lead->value ?? 0, 2) }}</dd>
                <dt class="font-medium text-neutral-500">Phone</dt><dd>{{ $lead->phone ?? '—' }} {{ $lead->phone_type ? '('.$lead->phone_type.')' : '' }}</dd>
                <dt class="font-medium text-neutral-500">Source</dt><dd>{{ $lead->source ?? '—' }}</dd>
                <dt class="font-medium text-neutral-500">Industry</dt><dd>{{ $lead->industry ?? '—' }}</dd>
                <dt class="font-medium text-neutral-500">Tags</dt><dd>{{ $lead->tags ?? '—' }}</dd>
                <dt class="font-medium text-neutral-500">Visibility</dt><dd>{{ ucfirst($lead->visibility) }}</dd>
                <dt class="font-medium text-neutral-500">Owners</dt><dd>{{ $lead->owners->pluck('name')->join(', ') ?: '—' }}</dd>
            </dl>
            @if($lead->description)
                <div class="mt-4 border-t pt-4 dark:border-neutral-700">
                    <p class="text-sm font-medium text-neutral-500 mb-1">Description</p>
                    <p class="text-sm">{{ $lead->description }}</p>
                </div>
            @endif
        </div>
    </div>
</x-layouts::app>
