<x-layouts::app :title="__('Task Details')">
    <div class="mx-auto max-w-4xl space-y-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <flux:button href="{{ route('crm.tasks.index') }}" variant="ghost" icon="arrow-left" size="sm" wire:navigate />
                <flux:heading size="xl">{{ $task->title }}</flux:heading>
            </div>
            <div class="flex gap-2">
                <flux:button href="{{ route('crm.tasks.edit', $task) }}" variant="primary" icon="pencil" wire:navigate>Edit</flux:button>
                <form method="POST" action="{{ route('crm.tasks.destroy', $task) }}" onsubmit="return confirm('Delete this task?')">
                    @csrf @method('DELETE')
                    <flux:button type="submit" variant="danger" icon="trash">Delete</flux:button>
                </form>
            </div>
        </div>

        @include('modules.crm.partials.flash')

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <div class="space-y-6 lg:col-span-2">
                <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
                    <flux:heading size="lg" class="mb-4">Task Details</flux:heading>
                    <dl class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <dt class="font-medium text-neutral-500">Category</dt>
                            <dd class="mt-1">{{ $task->category ?? '—' }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-neutral-500">Tags</dt>
                            <dd class="mt-1">
                                @if($task->tags)
                                    <div class="flex flex-wrap gap-1">
                                        @foreach(explode(',', $task->tags) as $tag)
                                            <span class="rounded bg-neutral-100 px-1.5 py-0.5 text-xs text-neutral-600 dark:bg-zinc-700 dark:text-neutral-300">{{ trim($tag) }}</span>
                                        @endforeach
                                    </div>
                                @else
                                    —
                                @endif
                            </dd>
                        </div>
                        <div>
                            <dt class="font-medium text-neutral-500">Start Date</dt>
                            <dd class="mt-1">{{ $task->start_date?->format('M d, Y') ?? '—' }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-neutral-500">Due Date</dt>
                            <dd class="mt-1">{{ $task->due_date?->format('M d, Y') ?? '—' }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-neutral-500">Priority</dt>
                            <dd class="mt-1">
                                @php $pc = ['High'=>'danger','Urgent'=>'danger','Medium'=>'warning','Low'=>'success']; @endphp
                                <flux:badge variant="{{ $pc[$task->priority] ?? 'secondary' }}" size="sm">{{ $task->priority ?? '—' }}</flux:badge>
                            </dd>
                        </div>
                        <div>
                            <dt class="font-medium text-neutral-500">Status</dt>
                            <dd class="mt-1">
                                @php $sc = ['Completed'=>'success','In Progress'=>'warning','Todo'=>'secondary','Under Review'=>'zinc']; @endphp
                                <flux:badge variant="{{ $sc[$task->status] ?? 'secondary' }}" size="sm">{{ $task->status ?? '—' }}</flux:badge>
                            </dd>
                        </div>
                    </dl>
                    @if($task->description)
                        <div class="mt-4 border-t border-neutral-100 pt-4 dark:border-neutral-700">
                            <dt class="mb-1 font-medium text-neutral-500 text-sm">Description</dt>
                            <dd class="text-sm text-neutral-700 dark:text-neutral-300">{{ $task->description }}</dd>
                        </div>
                    @endif
                </div>
            </div>

            <div class="space-y-6">
                <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
                    <flux:heading size="md" class="mb-3">Responsible Persons</flux:heading>
                    @forelse($task->responsiblePersons as $person)
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
            </div>
        </div>
    </div>
</x-layouts::app>
