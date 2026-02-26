<x-layouts::app :title="__('Contacts')">
    <div class="flex h-full w-full flex-1 flex-col gap-4">
        <div class="flex items-center justify-between">
            <flux:heading size="xl">Contacts</flux:heading>
            <flux:button href="{{ route('crm.contacts.create') }}" variant="primary" icon="plus" wire:navigate>
                Add Contact
            </flux:button>
        </div>

        @include('modules.crm.partials.flash')

        <div class="overflow-hidden rounded-xl border border-neutral-200 bg-white dark:border-neutral-700 dark:bg-zinc-900">
            <table class="w-full text-sm">
                <thead class="bg-neutral-50 dark:bg-zinc-800">
                    <tr>
                        <th class="px-4 py-3 text-left font-medium text-neutral-600 dark:text-neutral-300">Name</th>
                        <th class="px-4 py-3 text-left font-medium text-neutral-600 dark:text-neutral-300">Company</th>
                        <th class="px-4 py-3 text-left font-medium text-neutral-600 dark:text-neutral-300">Email</th>
                        <th class="px-4 py-3 text-left font-medium text-neutral-600 dark:text-neutral-300">Phone</th>
                        <th class="px-4 py-3 text-left font-medium text-neutral-600 dark:text-neutral-300">Owner</th>
                        <th class="px-4 py-3 text-right font-medium text-neutral-600 dark:text-neutral-300">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-100 dark:divide-neutral-700">
                    @forelse ($contacts as $contact)
                        <tr class="hover:bg-neutral-50 dark:hover:bg-zinc-800/50">
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    @if($contact->profile_image)
                                        <img src="{{ asset('storage/'.$contact->profile_image) }}" class="h-8 w-8 rounded-full object-cover" />
                                    @else
                                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-100 text-blue-600 text-xs font-bold">
                                            {{ strtoupper(substr($contact->first_name,0,1).substr($contact->last_name,0,1)) }}
                                        </div>
                                    @endif
                                    <div>
                                        <a href="{{ route('crm.contacts.show', $contact) }}" class="font-medium text-blue-600 hover:underline">
                                            {{ $contact->first_name }} {{ $contact->last_name }}
                                        </a>
                                        <p class="text-xs text-neutral-400">{{ $contact->job_title }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-neutral-600 dark:text-neutral-400">{{ $contact->company?->company_name ?? '—' }}</td>
                            <td class="px-4 py-3 text-neutral-600 dark:text-neutral-400">{{ $contact->email ?? '—' }}</td>
                            <td class="px-4 py-3 text-neutral-600 dark:text-neutral-400">{{ $contact->phone_1 ?? '—' }}</td>
                            <td class="px-4 py-3 text-neutral-600 dark:text-neutral-400">{{ $contact->owner?->name ?? '—' }}</td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex justify-end gap-2">
                                    <flux:button href="{{ route('crm.contacts.edit', $contact) }}" size="sm" variant="ghost" icon="pencil" wire:navigate />
                                    <form method="POST" action="{{ route('crm.contacts.destroy', $contact) }}" onsubmit="return confirm('Delete this contact?')">
                                        @csrf @method('DELETE')
                                        <flux:button type="submit" size="sm" variant="ghost" icon="trash" class="text-red-500" />
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-neutral-400">No contacts found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div>{{ $contacts->links() }}</div>
    </div>
</x-layouts::app>
