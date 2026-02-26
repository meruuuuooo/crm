<x-layouts::app :title="__('Add Pipeline')">
    <div class="mx-auto max-w-2xl">
        <div class="mb-6 flex items-center gap-3">
            <flux:button href="{{ route('crm.pipelines.index') }}" variant="ghost" icon="arrow-left" size="sm" wire:navigate />
            <flux:heading size="xl">Add Pipeline</flux:heading>
        </div>

        @include('modules.crm.partials.flash')

        <form method="POST" action="{{ route('crm.pipelines.store') }}" class="space-y-6">
            @csrf

            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
                <flux:heading size="lg" class="mb-4">Pipeline Details</flux:heading>
                <div class="space-y-4">
                    <flux:input name="name" label="Pipeline Name *" value="{{ old('name') }}" required />
                    <flux:select name="access_type" label="Access Type" placeholder="Select Access">
                        <flux:select.option value="public" :selected="old('access_type') === 'public'">Public</flux:select.option>
                        <flux:select.option value="private" :selected="old('access_type') === 'private'">Private</flux:select.option>
                        <flux:select.option value="team" :selected="old('access_type') === 'team'">Team Only</flux:select.option>
                    </flux:select>
                </div>
            </div>

            {{-- Stages Builder --}}
            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
                <div class="mb-4 flex items-center justify-between">
                    <flux:heading size="lg">Pipeline Stages</flux:heading>
                    <flux:button type="button" id="add-stage" variant="ghost" icon="plus" size="sm">Add Stage</flux:button>
                </div>
                <p class="mb-3 text-sm text-neutral-500">Define the stages deals pass through in this pipeline.</p>
                <div id="stages-container" class="space-y-2">
                    @php $oldStages = old('stages', ['Lead In', 'Contact Made', 'Proposal Sent', 'Negotiation', 'Closed Won']); @endphp
                    @foreach($oldStages as $i => $stage)
                        <div class="flex items-center gap-2 stage-row">
                            <div class="flex h-8 w-8 shrink-0 cursor-move items-center justify-center rounded text-neutral-400">☰</div>
                            <input type="text" name="stages[]" value="{{ $stage }}" class="flex-1 rounded-lg border border-neutral-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none dark:border-neutral-600 dark:bg-zinc-800 dark:text-white" />
                            <button type="button" class="remove-stage text-red-400 hover:text-red-600 px-2">✕</button>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Selected Persons (if team access) --}}
            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
                <flux:heading size="lg" class="mb-4">Access - Selected Persons</flux:heading>
                <p class="mb-3 text-sm text-neutral-500">If access is "Team Only", select who can access this pipeline.</p>
                <select name="selected_persons[]" multiple class="block w-full rounded-lg border border-neutral-300 bg-white px-3 py-2 text-sm focus:border-blue-500 focus:outline-none dark:border-neutral-600 dark:bg-zinc-800 dark:text-white">
                    @foreach($users as $u)
                        <option value="{{ $u->id }}" {{ in_array($u->id, old('selected_persons', [])) ? 'selected' : '' }}>{{ $u->name }}</option>
                    @endforeach
                </select>
                <p class="mt-1 text-xs text-neutral-400">Hold Ctrl/Cmd to select multiple</p>
            </div>

            <div class="flex justify-end gap-3">
                <flux:button href="{{ route('crm.pipelines.index') }}" variant="ghost" wire:navigate>Cancel</flux:button>
                <flux:button type="submit" variant="primary">Save Pipeline</flux:button>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('add-stage').addEventListener('click', () => {
            const container = document.getElementById('stages-container');
            const row = document.createElement('div');
            row.className = 'flex items-center gap-2 stage-row';
            row.innerHTML = `
                <div class="flex h-8 w-8 shrink-0 cursor-move items-center justify-center rounded text-neutral-400">☰</div>
                <input type="text" name="stages[]" placeholder="Stage name" class="flex-1 rounded-lg border border-neutral-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none dark:border-neutral-600 dark:bg-zinc-800 dark:text-white" />
                <button type="button" class="remove-stage text-red-400 hover:text-red-600 px-2">✕</button>
            `;
            container.appendChild(row);
        });

        document.getElementById('stages-container').addEventListener('click', e => {
            if (e.target.classList.contains('remove-stage')) {
                const rows = document.querySelectorAll('.stage-row');
                if (rows.length > 1) {
                    e.target.closest('.stage-row').remove();
                }
            }
        });
    </script>
</x-layouts::app>
