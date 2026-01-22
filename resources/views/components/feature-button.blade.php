@props(['title', 'description'])

<div class="feature-btn card h-100">
    <div class="card-body d-flex align-items-center gap-3 p-4">
        <div class="feature-icon" aria-hidden="true">
            {{ $icon ?? '' }}
        </div>
        <div class="text-start">
            <div class="feature-title fw-semibold">{{ $title }}</div>
            <div class="feature-desc text-muted small">{{ $description }}</div>
        </div>
    </div>
</div>


