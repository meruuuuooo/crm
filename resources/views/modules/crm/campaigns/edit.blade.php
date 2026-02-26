<x-layouts::app :title="__('Edit Campaign')">
    <div class="mx-auto max-w-4xl">
        <div class="mb-6 flex items-center gap-3">
            <flux:button href="{{ route('crm.campaigns.index') }}" variant="ghost" icon="arrow-left" size="sm" wire:navigate />
            <flux:heading size="xl">Edit Campaign — {{ $campaign->name }}</flux:heading>
        </div>
        @include('modules.crm.partials.flash')
        <form method="POST" action="{{ route('crm.campaigns.update', $campaign) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf @method('PUT')
            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-900">
                <flux:heading size="lg" class="mb-4">Basic Information</flux:heading>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <flux:input name="name" label="Name *" value="{{ old('name', $campaign->name) }}" required class="md:col-span-2" />
                    <flux:select name="campaign_type" label="Campaign Type" placeholder="Select Type">
                        @foreach(\App\Helpers\CrmOptions::campaignTypes() as $t)
                            <flux:select.option value="{{ $t }}" :selected="old('campaign_type', $campaign->campaign_type) === $t">{{ $t }}</flux:select.option>
                        @endforeach
                    </flux:select>
                    <flux:input name="deal_value" label="Deal Value" type="number" step="0.01" value="{{ old('deal_value', $campaign->deal_value) }}" />
                    <flux:select name="currency" label="Currency" placeholder="Select Currency">
                        @foreach(\App\Helpers\CrmOptions::currencies() as $cur)
                            <flux:select.option value="{{ $cur }}" :selected="old('currency', $campaign->currency) === $cur">{{ $cur }}</flux:select.option>
                        @endforeach
                    </flux:select>
                    <flux:select name="period" label="Period" placeholder="Select Period">
                        @foreach(\App\Helpers\CrmOptions::periods() as $p)
                            <flux:select.option value="{{ $p }}" :selected="old('period', $campaign->period) === $p">{{ $p }}</flux:select.option>
                        @endforeach
                    </flux:select>
                    <flux:input name="period_value" label="Period Value" type="number" step="0.01" value="{{ old('period_value', $campaign->period_value) }}" />
                    <flux:input name="target_audience" label="Target Audience" value="{{ old('target_audience', $campaign->target_audience) }}" class="md:col-span-2" />
                    <div class="md:col-span-2">
                        <flux:textarea name="description" label="Description" rows="4">{{ old('description', $campaign->description) }}</flux:textarea>
                    </div>
                    <div class="md:col-span-2">
                        <flux:label>Attachment</flux:label>
                        <input type="file" name="attachment" class="mt-1 block w-full text-sm text-neutral-600 file:mr-3 file:rounded-lg file:border-0 file:bg-blue-50 file:px-4 file:py-2 file:text-sm file:font-medium file:text-blue-700 hover:file:bg-blue-100" />
                        @if($campaign->attachment)
                            <p class="mt-1 text-xs text-neutral-500">Current: {{ basename($campaign->attachment) }}</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="flex justify-end gap-3">
                <flux:button href="{{ route('crm.campaigns.index') }}" variant="ghost" wire:navigate>Cancel</flux:button>
                <flux:button type="submit" variant="primary">Update Campaign</flux:button>
            </div>
        </form>
    </div>
</x-layouts::app>
