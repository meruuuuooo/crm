<x-layouts::app :title="__('Edit Project')">
    <div class="mx-auto max-w-4xl">
        <div class="mb-6 flex items-center gap-3">
            <flux:button href="{{ route('crm.projects.show', $project) }}" variant="ghost" icon="arrow-left" size="sm" wire:navigate />
            <flux:heading size="xl">Edit Project</flux:heading>
        </div>

        @include('modules.crm.partials.flash')

        <form method="POST" action="{{ route('crm.projects.update', $project) }}" class="space-y-6">
            @csrf @method('PUT')

            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
                <flux:heading size="lg" class="mb-4">Basic Information</flux:heading>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <flux:input name="name" label="Project Name *" value="{{ old('name', $project->name) }}" required class="md:col-span-2" />
                    <flux:input name="project_id_code" label="Project ID / Code" value="{{ old('project_id_code', $project->project_id_code) }}" />
                    <flux:select name="project_type" label="Project Type" placeholder="Select Type">
                        @foreach(\App\Helpers\CrmOptions::projectTypes() as $t)
                            <flux:select.option value="{{ $t }}" :selected="old('project_type', $project->project_type) === $t">{{ $t }}</flux:select.option>
                        @endforeach
                    </flux:select>
                    <flux:select name="client_id" label="Client (Contact)" placeholder="Select Client">
                        @foreach($contacts as $c)
                            <flux:select.option value="{{ $c->id }}" :selected="old('client_id', $project->client_id) == $c->id">{{ $c->first_name }} {{ $c->last_name }}</flux:select.option>
                        @endforeach
                    </flux:select>
                    <flux:select name="category" label="Category" placeholder="Select Category">
                        @foreach(['Design','Development','Marketing','Consulting','Research','Other'] as $cat)
                            <flux:select.option value="{{ $cat }}" :selected="old('category', $project->category) === $cat">{{ $cat }}</flux:select.option>
                        @endforeach
                    </flux:select>
                    <flux:select name="project_timing" label="Project Timing" placeholder="Select Timing">
                        @foreach(\App\Helpers\CrmOptions::projectTimings() as $t)
                            <flux:select.option value="{{ $t }}" :selected="old('project_timing', $project->project_timing) === $t">{{ $t }}</flux:select.option>
                        @endforeach
                    </flux:select>
                    <flux:input name="price" label="Price" type="number" step="0.01" min="0" value="{{ old('price', $project->price) }}" />
                    <flux:input name="start_date" label="Start Date" type="date" value="{{ old('start_date', $project->start_date?->format('Y-m-d')) }}" />
                    <flux:input name="due_date" label="Due Date" type="date" value="{{ old('due_date', $project->due_date?->format('Y-m-d')) }}" />
                    <flux:select name="priority" label="Priority" placeholder="Select Priority">
                        @foreach(\App\Helpers\CrmOptions::priorities() as $p)
                            <flux:select.option value="{{ $p }}" :selected="old('priority', $project->priority) === $p">{{ $p }}</flux:select.option>
                        @endforeach
                    </flux:select>
                    <flux:select name="status" label="Status" placeholder="Select Status">
                        @foreach(\App\Helpers\CrmOptions::projectStatuses() as $s)
                            <flux:select.option value="{{ $s }}" :selected="old('status', $project->status) === $s">{{ $s }}</flux:select.option>
                        @endforeach
                    </flux:select>
                    <div class="md:col-span-2">
                        <flux:textarea name="description" label="Description" rows="4">{{ old('description', $project->description) }}</flux:textarea>
                    </div>
                </div>
            </div>

            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
                <flux:heading size="lg" class="mb-4">Team</flux:heading>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                        <flux:label>Responsible Persons</flux:label>
                        <select name="responsible_persons[]" multiple class="mt-1 block w-full rounded-lg border border-neutral-300 bg-white px-3 py-2 text-sm focus:border-blue-500 focus:outline-none dark:border-neutral-600 dark:bg-zinc-800 dark:text-white">
                            @foreach($users as $u)
                                <option value="{{ $u->id }}" {{ in_array($u->id, old('responsible_persons', $project->responsiblePersons->pluck('id')->toArray())) ? 'selected' : '' }}>{{ $u->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <flux:label>Team Leaders</flux:label>
                        <select name="team_leaders[]" multiple class="mt-1 block w-full rounded-lg border border-neutral-300 bg-white px-3 py-2 text-sm focus:border-blue-500 focus:outline-none dark:border-neutral-600 dark:bg-zinc-800 dark:text-white">
                            @foreach($users as $u)
                                <option value="{{ $u->id }}" {{ in_array($u->id, old('team_leaders', $project->teamLeaders->pluck('id')->toArray())) ? 'selected' : '' }}>{{ $u->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <flux:button href="{{ route('crm.projects.show', $project) }}" variant="ghost" wire:navigate>Cancel</flux:button>
                <flux:button type="submit" variant="primary">Update Project</flux:button>
            </div>
        </form>
    </div>
</x-layouts::app>
