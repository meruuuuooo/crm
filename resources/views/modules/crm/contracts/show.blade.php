<x-layouts::app :title="__('Contract Details')">
    <div class="mx-auto max-w-4xl space-y-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <flux:button href="{{ route('crm.contracts.index') }}" variant="ghost" icon="arrow-left" size="sm" wire:navigate />
                <flux:heading size="xl">{{ $contract->subject }}</flux:heading>
            </div>
            <div class="flex gap-2">
                <flux:button href="{{ route('crm.contracts.edit', $contract) }}" variant="primary" icon="pencil" wire:navigate>Edit</flux:button>
                <form method="POST" action="{{ route('crm.contracts.destroy', $contract) }}" onsubmit="return confirm('Delete this contract?')">
                    @csrf @method('DELETE')
                    <flux:button type="submit" variant="danger" icon="trash">Delete</flux:button>
                </form>
            </div>
        </div>

        @include('modules.crm.partials.flash')

        <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
            <flux:heading size="lg" class="mb-4">Contract Details</flux:heading>
            <dl class="grid grid-cols-2 gap-4 text-sm md:grid-cols-3">
                <div>
                    <dt class="font-medium text-neutral-500">Client</dt>
                    <dd class="mt-1">
                        @if($contract->client)
                            <a href="{{ route('crm.contacts.show', $contract->client) }}" class="text-blue-600 hover:underline">
                                {{ $contract->client->first_name }} {{ $contract->client->last_name }}
                            </a>
                        @else
                            —
                        @endif
                    </dd>
                </div>
                <div>
                    <dt class="font-medium text-neutral-500">Contract Type</dt>
                    <dd class="mt-1">{{ $contract->contract_type ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="font-medium text-neutral-500">Contract Value</dt>
                    <dd class="mt-1">{{ $contract->contract_value ? number_format($contract->contract_value, 2) : '—' }}</dd>
                </div>
                <div>
                    <dt class="font-medium text-neutral-500">Start Date</dt>
                    <dd class="mt-1">{{ $contract->start_date?->format('M d, Y') ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="font-medium text-neutral-500">End Date</dt>
                    <dd class="mt-1">{{ $contract->end_date?->format('M d, Y') ?? '—' }}</dd>
                </div>
                @if($contract->attachment)
                    <div>
                        <dt class="font-medium text-neutral-500">Attachment</dt>
                        <dd class="mt-1">
                            <a href="{{ asset('storage/'.$contract->attachment) }}" target="_blank" class="text-blue-600 hover:underline">
                                {{ basename($contract->attachment) }}
                            </a>
                        </dd>
                    </div>
                @endif
            </dl>
            @if($contract->description)
                <div class="mt-4 border-t border-neutral-100 pt-4 dark:border-neutral-700">
                    <dt class="mb-1 font-medium text-neutral-500 text-sm">Description</dt>
                    <dd class="text-sm text-neutral-700 dark:text-neutral-300">{{ $contract->description }}</dd>
                </div>
            @endif
        </div>
    </div>
</x-layouts::app>
