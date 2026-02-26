<x-layouts::app :title="__('Estimation Details')">
    <div class="mx-auto max-w-4xl space-y-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <flux:button href="{{ route('crm.estimations.index') }}" variant="ghost" icon="arrow-left" size="sm" wire:navigate />
                <flux:heading size="xl">Estimation #{{ $estimation->id }}</flux:heading>
            </div>
            <div class="flex gap-2">
                <flux:button href="{{ route('crm.estimations.edit', $estimation) }}" variant="primary" icon="pencil" wire:navigate>Edit</flux:button>
                <form method="POST" action="{{ route('crm.estimations.destroy', $estimation) }}" onsubmit="return confirm('Delete this estimation?')">
                    @csrf @method('DELETE')
                    <flux:button type="submit" variant="danger" icon="trash">Delete</flux:button>
                </form>
            </div>
        </div>

        @include('modules.crm.partials.flash')

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <div class="space-y-6 lg:col-span-2">
                <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
                    <flux:heading size="lg" class="mb-4">Estimation Details</flux:heading>
                    <dl class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <dt class="font-medium text-neutral-500">Client</dt>
                            <dd class="mt-1">
                                @if($estimation->client)
                                    <a href="{{ route('crm.contacts.show', $estimation->client) }}" class="text-blue-600 hover:underline">
                                        {{ $estimation->client->first_name }} {{ $estimation->client->last_name }}
                                    </a>
                                @else —
                                @endif
                            </dd>
                        </div>
                        <div>
                            <dt class="font-medium text-neutral-500">Project</dt>
                            <dd class="mt-1">
                                @if($estimation->project)
                                    <a href="{{ route('crm.projects.show', $estimation->project) }}" class="text-blue-600 hover:underline">{{ $estimation->project->name }}</a>
                                @else —
                                @endif
                            </dd>
                        </div>
                        <div>
                            <dt class="font-medium text-neutral-500">Amount</dt>
                            <dd class="mt-1 font-semibold">{{ $estimation->currency }} {{ $estimation->amount ? number_format($estimation->amount, 2) : '—' }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-neutral-500">Estimated By</dt>
                            <dd class="mt-1">{{ $estimation->estimate_by ?? '—' }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-neutral-500">Estimate Date</dt>
                            <dd class="mt-1">{{ $estimation->estimate_date?->format('M d, Y') ?? '—' }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-neutral-500">Expiry Date</dt>
                            <dd class="mt-1">{{ $estimation->expiry_date?->format('M d, Y') ?? '—' }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-neutral-500">Status</dt>
                            <dd class="mt-1">
                                @php $sc = ['Approved'=>'success','Declined'=>'danger','Sent'=>'primary','Draft'=>'secondary','Expired'=>'zinc']; @endphp
                                <flux:badge variant="{{ $sc[$estimation->status] ?? 'secondary' }}" size="sm">{{ $estimation->status ?? '—' }}</flux:badge>
                            </dd>
                        </div>
                        @if($estimation->attachment)
                            <div>
                                <dt class="font-medium text-neutral-500">Attachment</dt>
                                <dd class="mt-1">
                                    <a href="{{ asset('storage/'.$estimation->attachment) }}" target="_blank" class="text-blue-600 hover:underline">{{ basename($estimation->attachment) }}</a>
                                </dd>
                            </div>
                        @endif
                    </dl>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    @if($estimation->bill_to)
                        <div class="rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-zinc-900">
                            <flux:heading size="sm" class="mb-2">Bill To</flux:heading>
                            <p class="text-sm whitespace-pre-line text-neutral-700 dark:text-neutral-300">{{ $estimation->bill_to }}</p>
                        </div>
                    @endif
                    @if($estimation->ship_to)
                        <div class="rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-zinc-900">
                            <flux:heading size="sm" class="mb-2">Ship To</flux:heading>
                            <p class="text-sm whitespace-pre-line text-neutral-700 dark:text-neutral-300">{{ $estimation->ship_to }}</p>
                        </div>
                    @endif
                </div>

                @if($estimation->description)
                    <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
                        <flux:heading size="md" class="mb-2">Notes</flux:heading>
                        <p class="text-sm text-neutral-700 dark:text-neutral-300">{{ $estimation->description }}</p>
                    </div>
                @endif
            </div>

            <div class="space-y-6">
                @if($estimation->tags)
                    <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
                        <flux:heading size="md" class="mb-3">Tags</flux:heading>
                        <div class="flex flex-wrap gap-1">
                            @foreach(explode(',', $estimation->tags) as $tag)
                                <span class="rounded bg-neutral-100 px-1.5 py-0.5 text-xs text-neutral-600 dark:bg-zinc-700 dark:text-neutral-300">{{ trim($tag) }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts::app>
