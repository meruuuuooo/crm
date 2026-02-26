<x-layouts::app :title="__('Proposal Details')">
    <div class="mx-auto max-w-4xl space-y-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <flux:button href="{{ route('crm.proposals.index') }}" variant="ghost" icon="arrow-left" size="sm" wire:navigate />
                <flux:heading size="xl">{{ $proposal->subject }}</flux:heading>
            </div>
            <div class="flex gap-2">
                <flux:button href="{{ route('crm.proposals.edit', $proposal) }}" variant="primary" icon="pencil" wire:navigate>Edit</flux:button>
                <form method="POST" action="{{ route('crm.proposals.destroy', $proposal) }}" onsubmit="return confirm('Delete this proposal?')">
                    @csrf @method('DELETE')
                    <flux:button type="submit" variant="danger" icon="trash">Delete</flux:button>
                </form>
            </div>
        </div>

        @include('modules.crm.partials.flash')

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <div class="space-y-6 lg:col-span-2">
                <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
                    <flux:heading size="lg" class="mb-4">Proposal Details</flux:heading>
                    <dl class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <dt class="font-medium text-neutral-500">Date</dt>
                            <dd class="mt-1">{{ $proposal->date?->format('M d, Y') ?? '—' }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-neutral-500">Open Till</dt>
                            <dd class="mt-1">{{ $proposal->open_till?->format('M d, Y') ?? '—' }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-neutral-500">Client</dt>
                            <dd class="mt-1">
                                @if($proposal->client)
                                    <a href="{{ route('crm.contacts.show', $proposal->client) }}" class="text-blue-600 hover:underline">
                                        {{ $proposal->client->first_name }} {{ $proposal->client->last_name }}
                                    </a>
                                @else
                                    —
                                @endif
                            </dd>
                        </div>
                        <div>
                            <dt class="font-medium text-neutral-500">Project</dt>
                            <dd class="mt-1">
                                @if($proposal->project)
                                    <a href="{{ route('crm.projects.show', $proposal->project) }}" class="text-blue-600 hover:underline">{{ $proposal->project->name }}</a>
                                @else
                                    —
                                @endif
                            </dd>
                        </div>
                        <div>
                            <dt class="font-medium text-neutral-500">Deal</dt>
                            <dd class="mt-1">
                                @if($proposal->deal)
                                    <a href="{{ route('crm.deals.show', $proposal->deal) }}" class="text-blue-600 hover:underline">{{ $proposal->deal->deal_name }}</a>
                                @else
                                    —
                                @endif
                            </dd>
                        </div>
                        <div>
                            <dt class="font-medium text-neutral-500">Related To</dt>
                            <dd class="mt-1">{{ $proposal->related_to ?? '—' }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-neutral-500">Currency</dt>
                            <dd class="mt-1">{{ $proposal->currency ?? '—' }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-neutral-500">Status</dt>
                            <dd class="mt-1">
                                @php $sc = ['Accepted'=>'success','Declined'=>'danger','Sent'=>'primary','Draft'=>'secondary','Expired'=>'zinc']; @endphp
                                <flux:badge variant="{{ $sc[$proposal->status] ?? 'secondary' }}" size="sm">{{ $proposal->status ?? '—' }}</flux:badge>
                            </dd>
                        </div>
                        @if($proposal->tags)
                            <div class="col-span-2">
                                <dt class="font-medium text-neutral-500">Tags</dt>
                                <dd class="mt-1 flex flex-wrap gap-1">
                                    @foreach(explode(',', $proposal->tags) as $tag)
                                        <span class="rounded bg-neutral-100 px-1.5 py-0.5 text-xs text-neutral-600 dark:bg-zinc-700 dark:text-neutral-300">{{ trim($tag) }}</span>
                                    @endforeach
                                </dd>
                            </div>
                        @endif
                        @if($proposal->attachment)
                            <div class="col-span-2">
                                <dt class="font-medium text-neutral-500">Attachment</dt>
                                <dd class="mt-1">
                                    <a href="{{ asset('storage/'.$proposal->attachment) }}" target="_blank" class="text-blue-600 hover:underline text-sm">
                                        {{ basename($proposal->attachment) }}
                                    </a>
                                </dd>
                            </div>
                        @endif
                    </dl>
                    @if($proposal->description)
                        <div class="mt-4 border-t border-neutral-100 pt-4 dark:border-neutral-700">
                            <dt class="mb-1 font-medium text-neutral-500 text-sm">Description</dt>
                            <dd class="text-sm text-neutral-700 dark:text-neutral-300">{{ $proposal->description }}</dd>
                        </div>
                    @endif
                </div>
            </div>

            <div class="space-y-6">
                <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
                    <flux:heading size="md" class="mb-3">Assignees</flux:heading>
                    @forelse($proposal->assignees as $assignee)
                        <div class="flex items-center gap-2 py-1 text-sm">
                            <div class="h-7 w-7 rounded-full bg-purple-100 flex items-center justify-center text-purple-700 font-medium text-xs">
                                {{ strtoupper(substr($assignee->name, 0, 1)) }}
                            </div>
                            {{ $assignee->name }}
                        </div>
                    @empty
                        <p class="text-sm text-neutral-400">None assigned</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-layouts::app>
