<x-layouts::app :title="__('Projects')">
    <div class="flex h-full w-full flex-1 flex-col gap-4">
        <div class="flex items-center justify-between">
            <flux:heading size="xl">Projects</flux:heading>
            <flux:button href="{{ route('crm.projects.create') }}" variant="primary" icon="plus" wire:navigate>Add Project</flux:button>
        </div>

        @include('modules.crm.partials.flash')

        <div class="overflow-hidden rounded-xl border border-neutral-200 bg-white dark:border-neutral-700 dark:bg-zinc-900">
            <table class="w-full text-sm">
                <thead class="bg-neutral-50 dark:bg-zinc-800">
                    <tr>
                        <th class="px-4 py-3 text-left font-medium text-neutral-600 dark:text-neutral-300">Project</th>
                        <th class="px-4 py-3 text-left font-medium text-neutral-600 dark:text-neutral-300">Type</th>
                        <th class="px-4 py-3 text-left font-medium text-neutral-600 dark:text-neutral-300">Client</th>
                        <th class="px-4 py-3 text-left font-medium text-neutral-600 dark:text-neutral-300">Price</th>
                        <th class="px-4 py-3 text-left font-medium text-neutral-600 dark:text-neutral-300">Due Date</th>
                        <th class="px-4 py-3 text-left font-medium text-neutral-600 dark:text-neutral-300">Priority</th>
                        <th class="px-4 py-3 text-left font-medium text-neutral-600 dark:text-neutral-300">Status</th>
                        <th class="px-4 py-3 text-right font-medium text-neutral-600 dark:text-neutral-300">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-100 dark:divide-neutral-700">
                    @forelse ($projects as $project)
                        <tr class="hover:bg-neutral-50 dark:hover:bg-zinc-800/50">
                            <td class="px-4 py-3 font-medium">
                                <a href="{{ route('crm.projects.show', $project) }}" class="text-blue-600 hover:underline">{{ $project->name }}</a>
                                @if($project->project_id_code)
                                    <div class="text-xs text-neutral-400">#{{ $project->project_id_code }}</div>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-neutral-600 dark:text-neutral-400">{{ $project->project_type ?? '—' }}</td>
                            <td class="px-4 py-3 text-neutral-600 dark:text-neutral-400">{{ $project->client?->first_name.' '.$project->client?->last_name ?? '—' }}</td>
                            <td class="px-4 py-3 text-neutral-600 dark:text-neutral-400">{{ $project->price ? number_format($project->price, 2) : '—' }}</td>
                            <td class="px-4 py-3 text-neutral-600 dark:text-neutral-400">{{ $project->due_date?->format('M d, Y') ?? '—' }}</td>
                            <td class="px-4 py-3">
                                @php $pc = ['High'=>'danger','Urgent'=>'danger','Medium'=>'warning','Low'=>'success']; @endphp
                                <flux:badge variant="{{ $pc[$project->priority] ?? 'secondary' }}" size="sm">{{ $project->priority ?? '—' }}</flux:badge>
                            </td>
                            <td class="px-4 py-3">
                                @php $sc = ['Completed'=>'success','In Progress'=>'warning','Not Started'=>'secondary','On Hold'=>'zinc','Cancelled'=>'danger']; @endphp
                                <flux:badge variant="{{ $sc[$project->status] ?? 'secondary' }}" size="sm">{{ $project->status ?? '—' }}</flux:badge>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex justify-end gap-2">
                                    <flux:button href="{{ route('crm.projects.edit', $project) }}" size="sm" variant="ghost" icon="pencil" wire:navigate />
                                    <form method="POST" action="{{ route('crm.projects.destroy', $project) }}" onsubmit="return confirm('Delete this project?')">
                                        @csrf @method('DELETE')
                                        <flux:button type="submit" size="sm" variant="ghost" icon="trash" class="text-red-500" />
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-8 text-center text-neutral-400">No projects found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div>{{ $projects->links() }}</div>
    </div>
</x-layouts::app>
