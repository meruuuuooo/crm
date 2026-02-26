<x-layouts::app :title="__('Project Details')">
    <div class="mx-auto max-w-4xl space-y-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <flux:button href="{{ route('crm.projects.index') }}" variant="ghost" icon="arrow-left" size="sm" wire:navigate />
                <flux:heading size="xl">{{ $project->name }}</flux:heading>
                @if($project->project_id_code)
                    <flux:badge variant="secondary" size="sm">#{{ $project->project_id_code }}</flux:badge>
                @endif
            </div>
            <div class="flex gap-2">
                <flux:button href="{{ route('crm.projects.edit', $project) }}" variant="primary" icon="pencil" wire:navigate>Edit</flux:button>
                <form method="POST" action="{{ route('crm.projects.destroy', $project) }}" onsubmit="return confirm('Delete this project?')">
                    @csrf @method('DELETE')
                    <flux:button type="submit" variant="danger" icon="trash">Delete</flux:button>
                </form>
            </div>
        </div>

        @include('modules.crm.partials.flash')

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            {{-- Main Info --}}
            <div class="space-y-6 lg:col-span-2">
                <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
                    <flux:heading size="lg" class="mb-4">Project Details</flux:heading>
                    <dl class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <dt class="font-medium text-neutral-500">Type</dt>
                            <dd class="mt-1">{{ $project->project_type ?? '—' }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-neutral-500">Category</dt>
                            <dd class="mt-1">{{ $project->category ?? '—' }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-neutral-500">Client</dt>
                            <dd class="mt-1">
                                @if($project->client)
                                    <a href="{{ route('crm.contacts.show', $project->client) }}" class="text-blue-600 hover:underline">
                                        {{ $project->client->first_name }} {{ $project->client->last_name }}
                                    </a>
                                @else
                                    —
                                @endif
                            </dd>
                        </div>
                        <div>
                            <dt class="font-medium text-neutral-500">Project Timing</dt>
                            <dd class="mt-1">{{ $project->project_timing ?? '—' }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-neutral-500">Price</dt>
                            <dd class="mt-1">{{ $project->price ? number_format($project->price, 2) : '—' }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-neutral-500">Start Date</dt>
                            <dd class="mt-1">{{ $project->start_date?->format('M d, Y') ?? '—' }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-neutral-500">Due Date</dt>
                            <dd class="mt-1">{{ $project->due_date?->format('M d, Y') ?? '—' }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-neutral-500">Priority</dt>
                            <dd class="mt-1">
                                @php $pc = ['High'=>'danger','Urgent'=>'danger','Medium'=>'warning','Low'=>'success']; @endphp
                                <flux:badge variant="{{ $pc[$project->priority] ?? 'secondary' }}" size="sm">{{ $project->priority ?? '—' }}</flux:badge>
                            </dd>
                        </div>
                        <div>
                            <dt class="font-medium text-neutral-500">Status</dt>
                            <dd class="mt-1">
                                @php $sc = ['Completed'=>'success','In Progress'=>'warning','Not Started'=>'secondary','On Hold'=>'zinc','Cancelled'=>'danger']; @endphp
                                <flux:badge variant="{{ $sc[$project->status] ?? 'secondary' }}" size="sm">{{ $project->status ?? '—' }}</flux:badge>
                            </dd>
                        </div>
                    </dl>
                    @if($project->description)
                        <div class="mt-4 border-t border-neutral-100 pt-4 dark:border-neutral-700">
                            <dt class="mb-1 font-medium text-neutral-500 text-sm">Description</dt>
                            <dd class="text-sm text-neutral-700 dark:text-neutral-300">{{ $project->description }}</dd>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="space-y-6">
                <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
                    <flux:heading size="md" class="mb-3">Responsible Persons</flux:heading>
                    @forelse($project->responsiblePersons as $person)
                        <div class="flex items-center gap-2 py-1 text-sm">
                            <div class="h-7 w-7 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-medium text-xs">
                                {{ strtoupper(substr($person->name, 0, 1)) }}
                            </div>
                            {{ $person->name }}
                        </div>
                    @empty
                        <p class="text-sm text-neutral-400">None assigned</p>
                    @endforelse
                </div>

                <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
                    <flux:heading size="md" class="mb-3">Team Leaders</flux:heading>
                    @forelse($project->teamLeaders as $leader)
                        <div class="flex items-center gap-2 py-1 text-sm">
                            <div class="h-7 w-7 rounded-full bg-green-100 flex items-center justify-center text-green-700 font-medium text-xs">
                                {{ strtoupper(substr($leader->name, 0, 1)) }}
                            </div>
                            {{ $leader->name }}
                        </div>
                    @empty
                        <p class="text-sm text-neutral-400">None assigned</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-layouts::app>
