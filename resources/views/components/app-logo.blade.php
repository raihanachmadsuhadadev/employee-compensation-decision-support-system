@props([
    'showText' => true,
    'subtitle' => 'Decision Support System',
])

<span {{ $attributes->class(['d-inline-flex align-items-center']) }}>
    @if ($showText)
        <span class="d-flex flex-column overflow-hidden text-start">
            <span class="app-logo-title fw-bold text-truncate">Compensation DSS</span>
            @if ($subtitle)
                <span class="app-logo-subtitle text-muted text-truncate">{{ $subtitle }}</span>
            @endif
        </span>
    @endif
</span>
