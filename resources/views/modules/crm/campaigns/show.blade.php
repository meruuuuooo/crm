<x-layouts::app :title="__('Campaign Details')">
    <div class="mx-auto max-w-4xl space-y-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <flux:button href="{{ route('crm.campaigns.index') }}" variant="ghost" icon="arrow-left" size="sm" wire:navigate />
                <flux:heading size="xl">{{ $campaign->name }}</flux:heading>
            </div>
            <div class="flex gap-2">
                <flux:button href="{{ route('crm.campaigns.edit', $campaign) }}" variant="primary" icon="pencil" wire:navigate>Edit</flux:button>
                <form method="POST" action="{{ route('crm.campaigns.destroy', $campaign) }}" onsubmit="return confirm('Delete this campaign?')">
                    @csrf @method('DELETE')
                    <flux:button type="submit" variant="danger" icon="trash">Delete</flux:button>
                </form>
            </div>
        </div>

        @include('modules.crm.partials.flash')

        <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
            <flux:heading size="lg" class="mb-4">Campaign Details</flux:heading>
            <dl class="grid grid-cols-2 gap-4 text-sm md:grid-cols-3">
                <div>
                    <dt class="font-medium text-neutral-500">Type</dt>
                    <dd class="mt-1">{{ $campaign->campaign_type ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="font-medium text-neutral-500">Deal Value</dt>
                    <dd class="mt-1">{{ $campaign->currency }} {{ $campaign->deal_value ? number_format($campaign->deal_value, 2) : '—' }}</dd>
                </div>
                <div>
                    <dt class="font-medium text-neutral-500">Period</dt>
                    <dd class="mt-1">{{ $campaign->period ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="font-medium text-neutral-500">Period Value</dt>
                    <dd class="mt-1">{{ $campaign->period_value ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="font-medium text-neutral-500">Target Audience</dt>
                    <dd class="mt-1">{{ $campaign->target_audience ?? '—' }}</dd>
                </div>
                @if($campaign->attachment)
                    <div>
                        <dt class="font-medium text-neutral-500">Attachment</dt>
                        <dd class="mt-1">
                            <a href="{{ asset('storage/'.$campaign->attachment) }}" target="_blank" class="text-blue-600 hover:underline">{{ basename($campaign->attachment) }}</a>
                        </dd>
                    </div>
                @endif
            </dl>
            @if($campaign->description)
                <div class="mt-4 border-t border-neutral-100 pt-4 dark:border-neutral-700">
                    <dt class="mb-1 font-medium text-neutral-500 text-sm">Description</dt>
                    <dd class="text-sm text-neutral-700 dark:text-neutral-300">{{ $campaign->description }}</dd>
                </div>
            @endif
        </div>
    </div>
</x-layouts::app>
