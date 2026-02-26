<x-layouts::app :title="__('Tasks')">
    <div class="flex h-full w-full flex-1 flex-col gap-4">
        <div class="flex items-center justify-between">
            <flux:heading size="xl">Tasks</flux:heading>
            <flux:button href="{{ route('crm.tasks.create') }}" variant="primary" icon="plus" wire:navigate>Add Task</flux:button>
        </div>

        @include('modules.crm.partials.flash')

        <div class="overflow-hidden rounded-xl border border-neutral-200 bg-white dark:border-neutral-700 dark:bg-zinc-900">
            <table class="w-full text-sm">
                <thead class="bg-neutral-50 dark:bg-zinc-800">
                    <tr>
                        <th class="px-4 py-3 text-left font-medium text-neutral-600 dark:text-neutral-300">Title</th>
                        <th class="px-4 py-3 text-left font-medium text-neutral-600 dark:text-neutral-300">Category</th>
                        <th class="px-4 py-3 text-left font-medium text-neutral-600 dark:text-neutral-300">Start Date</th>
                        <th class="px-4 py-3 text-left font-medium text-neutral-600 dark:text-neutral-300">Due Date</th>
                        <th class="px-4 py-3 text-left font-medium text-neutral-600 dark:text-neutral-300">Priority</th>
                        <th class="px-4 py-3 text-left font-medium text-neutral-600 dark:text-neutral-300">Status</th>
                        <th class="px-4 py-3 text-right font-medium text-neutral-600 dark:text-neutral-300">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-100 dark:divide-neutral-700">
                    @forelse ($tasks as $task)
                        <tr class="hover:bg-neutral-50 dark:hover:bg-zinc-800/50">
                            <td class="px-4 py-3 font-medium">
                                <a href="{{ route('crm.tasks.show', $task) }}" class="text-blue-600 hover:underline">{{ $task->title }}</a>
                                @if($task->tags)
                                    <div class="mt-0.5 flex flex-wrap gap-1">
                                        @foreach(explode(',', $task->tags) as $tag)
                                            <span class="rounded bg-neutral-100 px-1.5 py-0.5 text-xs text-neutral-600 dark:bg-zinc-700 dark:text-neutral-300">{{ trim($tag) }}</span>
                                        @endforeach
                                    </div>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-neutral-600 dark:text-neutral-400">{{ $task->category ?? '—' }}</td>
                            <td class="px-4 py-3 text-neutral-600 dark:text-neutral-400">{{ $task->start_date?->format('M d, Y') ?? '—' }}</td>
                            <td class="px-4 py-3 text-neutral-600 dark:text-neutral-400">{{ $task->due_date?->format('M d, Y') ?? '—' }}</td>
                            <td class="px-4 py-3">
                                @php $pc = ['High'=>'danger','Urgent'=>'danger','Medium'=>'warning','Low'=>'success']; @endphp
                                <flux:badge variant="{{ $pc[$task->priority] ?? 'secondary' }}" size="sm">{{ $task->priority ?? '—' }}</flux:badge>
                            </td>
                            <td class="px-4 py-3">
                                @php $sc = ['Completed'=>'success','In Progress'=>'warning','Todo'=>'secondary','Under Review'=>'zinc']; @endphp
                                <flux:badge variant="{{ $sc[$task->status] ?? 'secondary' }}" size="sm">{{ $task->status ?? '—' }}</flux:badge>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex justify-end gap-2">
                                    <flux:button href="{{ route('crm.tasks.edit', $task) }}" size="sm" variant="ghost" icon="pencil" wire:navigate />
                                    <form method="POST" action="{{ route('crm.tasks.destroy', $task) }}" onsubmit="return confirm('Delete this task?')">
                                        @csrf @method('DELETE')
                                        <flux:button type="submit" size="sm" variant="ghost" icon="trash" class="text-red-500" />
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-neutral-400">No tasks found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div>{{ $tasks->links() }}</div>
    </div>
</x-layouts::app>
