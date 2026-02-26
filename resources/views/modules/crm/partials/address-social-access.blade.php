{{-- Address Information --}}
<div class="mt-6">
    <flux:separator text="Address Information" />
    <div class="mt-4 grid grid-cols-1 gap-4 md:grid-cols-2">
        <div class="md:col-span-2">
            <flux:input name="street_address" label="Street Address" value="{{ old('street_address', $model->street_address ?? '') }}" />
        </div>
        <flux:select name="country" label="Country" placeholder="Select Country">
            @foreach(\App\Helpers\CrmOptions::countries() as $country)
                <flux:select.option value="{{ $country }}" :selected="old('country', $model->country ?? '') === $country">{{ $country }}</flux:select.option>
            @endforeach
        </flux:select>
        <flux:select name="state" label="State / Province" placeholder="Select State">
            @foreach(\App\Helpers\CrmOptions::states() as $state)
                <flux:select.option value="{{ $state }}" :selected="old('state', $model->state ?? '') === $state">{{ $state }}</flux:select.option>
            @endforeach
        </flux:select>
        <flux:select name="city" label="City" placeholder="Select City">
            @foreach(\App\Helpers\CrmOptions::cities() as $city)
                <flux:select.option value="{{ $city }}" :selected="old('city', $model->city ?? '') === $city">{{ $city }}</flux:select.option>
            @endforeach
        </flux:select>
        <flux:input name="zipcode" label="Zipcode" value="{{ old('zipcode', $model->zipcode ?? '') }}" />
    </div>
</div>

{{-- Social Profile --}}
<div class="mt-6">
    <flux:separator text="Social Profile" />
    <div class="mt-4 grid grid-cols-1 gap-4 md:grid-cols-2">
        <flux:input name="facebook" label="Facebook" value="{{ old('facebook', $model->facebook ?? '') }}" placeholder="https://facebook.com/..." />
        <flux:input name="skype" label="Skype" value="{{ old('skype', $model->skype ?? '') }}" />
        <flux:input name="linkedin" label="LinkedIn" value="{{ old('linkedin', $model->linkedin ?? '') }}" placeholder="https://linkedin.com/in/..." />
        <flux:input name="twitter" label="Twitter" value="{{ old('twitter', $model->twitter ?? '') }}" placeholder="@username" />
        <flux:input name="whatsapp" label="WhatsApp" value="{{ old('whatsapp', $model->whatsapp ?? '') }}" />
        <flux:input name="instagram" label="Instagram" value="{{ old('instagram', $model->instagram ?? '') }}" placeholder="@username" />
    </div>
</div>

{{-- Access Settings --}}
<div class="mt-6">
    <flux:separator text="Access Settings" />
    <div class="mt-4">
        <flux:label>Visibility</flux:label>
        <div class="mt-2 flex gap-6">
            @foreach(['public' => 'Public', 'private' => 'Private', 'team' => 'Team'] as $val => $label)
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio" name="visibility" value="{{ $val }}"
                           {{ old('visibility', $model->visibility ?? 'public') === $val ? 'checked' : '' }}
                           class="text-blue-600" />
                    <span class="text-sm">{{ $label }}</span>
                </label>
            @endforeach
        </div>
    </div>
</div>
