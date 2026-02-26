<x-layouts::app :title="__('Pipelines')">
    <div class="flex h-full w-full flex-1 flex-col gap-4">
        <div class="flex items-center justify-between">
            <flux:heading size="xl">Pipelines</flux:heading>
            <flux:button href="{{ route('crm.pipelines.create') }}" variant="primary" icon="plus" wire:navigate>Add Pipeline</flux:button>
        </div>

        @include('modules.crm.partials.flash')

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
            @forelse ($pipelines as $pipeline)
                <div class="rounded-xl border border-neutral-200 bg-white p-5 dark:border-neutral-700 dark:bg-zinc-900">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="font-semibold text-neutral-900 dark:text-white">{{ $pipeline->name }}</h3>
                            <p class="mt-0.5 text-sm text-neutral-500">
                                <flux:badge variant="{{ $pipeline->access_type === 'public' ? 'success' : 'secondary' }}" size="sm">{{ ucfirst($pipeline->access_type ?? 'private') }}</flux:badge>
                            </p>
                        </div>
                        <div class="flex gap-1">
                            <flux:button href="{{ route('crm.pipelines.edit', $pipeline) }}" size="sm" variant="ghost" icon="pencil" wire:navigate />
                            <form method="POST" action="{{ route('crm.pipelines.destroy', $pipeline) }}" onsubmit="return confirm('Delete this pipeline?')">
                                @csrf @method('DELETE')
                                <flux:button type="submit" size="sm" variant="ghost" icon="trash" class="text-red-500" />
                            </form>
                        </div>
                    </div>

                    @if($pipeline->stages && count($pipeline->stages))
                        <div class="mt-4">
                            <p class="mb-2 text-xs font-medium uppercase tracking-wide text-neutral-400">Stages</p>
                            <div class="flex flex-wrap gap-1">
                                @foreach($pipeline->stages as $stage)
                                    <span class="rounded-full bg-blue-50 px-2.5 py-1 text-xs text-blue-700 dark:bg-blue-900/30 dark:text-blue-300">{{ $stage }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="mt-4 flex items-center justify-between border-t border-neutral-100 pt-3 dark:border-neutral-700">
                        <span class="text-xs text-neutral-500">{{ $pipeline->deals->count() }} deals</span>
                        <a href="{{ route('crm.deals.index') }}?pipeline={{ $pipeline->id }}" class="text-xs text-blue-600 hover:underline">View Deals →</a>
                    </div>
                </div>
            @empty
                <div class="col-span-3 rounded-xl border-2 border-dashed border-neutral-200 p-12 text-center dark:border-neutral-700">
                    <p class="text-neutral-400">No pipelines yet. Create your first pipeline to organize deals.</p>
                    <div class="mt-4">
                        <flux:button href="{{ route('crm.pipelines.create') }}" variant="primary" icon="plus" size="sm" wire:navigate>Create Pipeline</flux:button>
                    </div>
                </div>
            @endforelse
        </div>
        <div>{{ $pipelines->links() }}</div>
    </div>
</x-layouts::app>
