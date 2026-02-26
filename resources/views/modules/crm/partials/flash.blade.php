@if (session('success'))
    <flux:callout variant="success" icon="check-badge" class="mb-4">
        {{ session('success') }}
    </flux:callout>
@endif

@if ($errors->any())
    <flux:callout variant="danger" icon="exclamation-triangle" class="mb-4">
        <ul class="list-disc list-inside text-sm">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </flux:callout>
@endif
