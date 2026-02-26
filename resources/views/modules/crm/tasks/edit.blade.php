<x-layouts::app :title="__('Edit Task')">
    <div class="mx-auto max-w-4xl">
        <div class="mb-6 flex items-center gap-3">
            <flux:button href="{{ route('crm.tasks.show', $task) }}" variant="ghost" icon="arrow-left" size="sm" wire:navigate />
            <flux:heading size="xl">Edit Task</flux:heading>
        </div>

        @include('modules.crm.partials.flash')

        <form method="POST" action="{{ route('crm.tasks.update', $task) }}" class="space-y-6">
            @csrf @method('PUT')

            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
                <flux:heading size="lg" class="mb-4">Task Details</flux:heading>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <flux:input name="title" label="Task Title *" value="{{ old('title', $task->title) }}" required class="md:col-span-2" />
                    <flux:select name="category" label="Category" placeholder="Select Category">
                        @foreach(['Bug Fix','Feature','Research','Meeting','Review','Documentation','Other'] as $cat)
                            <flux:select.option value="{{ $cat }}" :selected="old('category', $task->category) === $cat">{{ $cat }}</flux:select.option>
                        @endforeach
                    </flux:select>
                    <flux:input name="tags" label="Tags" value="{{ old('tags', $task->tags) }}" placeholder="e.g. urgent, backend, v2" />
                    <flux:input name="start_date" label="Start Date" type="date" value="{{ old('start_date', $task->start_date?->format('Y-m-d')) }}" />
                    <flux:input name="due_date" label="Due Date" type="date" value="{{ old('due_date', $task->due_date?->format('Y-m-d')) }}" />
                    <flux:select name="priority" label="Priority" placeholder="Select Priority">
                        @foreach(\App\Helpers\CrmOptions::priorities() as $p)
                            <flux:select.option value="{{ $p }}" :selected="old('priority', $task->priority) === $p">{{ $p }}</flux:select.option>
                        @endforeach
                    </flux:select>
                    <flux:select name="status" label="Status" placeholder="Select Status">
                        @foreach(\App\Helpers\CrmOptions::taskStatuses() as $s)
                            <flux:select.option value="{{ $s }}" :selected="old('status', $task->status) === $s">{{ $s }}</flux:select.option>
                        @endforeach
                    </flux:select>
                    <div class="md:col-span-2">
                        <flux:textarea name="description" label="Description" rows="4">{{ old('description', $task->description) }}</flux:textarea>
                    </div>
                </div>
            </div>

            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
                <flux:heading size="lg" class="mb-4">Responsible Persons</flux:heading>
                <div>
                    <select name="responsible_persons[]" multiple class="block w-full rounded-lg border border-neutral-300 bg-white px-3 py-2 text-sm focus:border-blue-500 focus:outline-none dark:border-neutral-600 dark:bg-zinc-800 dark:text-white">
                        @foreach($users as $u)
                            <option value="{{ $u->id }}" {{ in_array($u->id, old('responsible_persons', $task->responsiblePersons->pluck('id')->toArray())) ? 'selected' : '' }}>{{ $u->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <flux:button href="{{ route('crm.tasks.show', $task) }}" variant="ghost" wire:navigate>Cancel</flux:button>
                <flux:button type="submit" variant="primary">Update Task</flux:button>
            </div>
        </form>
    </div>
</x-layouts::app>
