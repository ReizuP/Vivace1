@props(['category'])

<a href="{{ route('products.category', ['category' => $category->slug]) }}" class="text-decoration-none category-card-link">
    <div class="card category-card h-100 text-center">
        <div class="card-body d-flex flex-column align-items-center justify-content-center p-4">
            <div class="category-icon mb-3">
                @php
                    // Determine icon based on category name
                    $categoryName = strtolower($category->name);
                    $iconType = 'music'; // default
                    
                    if (strpos($categoryName, 'guitar') !== false) {
                        $iconType = 'guitar';
                    } elseif (strpos($categoryName, 'keyboard') !== false || strpos($categoryName, 'piano') !== false) {
                        $iconType = 'keyboard';
                    } elseif (strpos($categoryName, 'drum') !== false || strpos($categoryName, 'percussion') !== false) {
                        $iconType = 'drum';
                    } elseif (strpos($categoryName, 'wind') !== false || strpos($categoryName, 'trumpet') !== false || strpos($categoryName, 'sax') !== false) {
                        $iconType = 'wind';
                    } elseif (strpos($categoryName, 'string') !== false || strpos($categoryName, 'violin') !== false) {
                        $iconType = 'string';
                    } elseif (strpos($categoryName, 'accessor') !== false) {
                        $iconType = 'accessory';
                    }
                @endphp

                @if($iconType === 'guitar')
                    <!-- Guitar SVG Icon - Clean Silhouette -->
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20.38 3.46L19 2.08c-.37-.37-.88-.58-1.42-.58s-1.05.21-1.42.58L11 7.5 2.5 16c-.78.78-.78 2.05 0 2.83L5.17 21c.78.78 2.05.78 2.83 0L16.5 13l4.92-4.92c.37-.37.58-.88.58-1.42s-.21-1.05-.58-1.42l-1.04-1.04zM12 10l-2 2 2 2 2-2-2-2z" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M7 13l-2-2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        <circle cx="9" cy="15" r="1" fill="currentColor"/>
                        <circle cx="15" cy="9" r="1" fill="currentColor"/>
                    </svg>
                @elseif($iconType === 'keyboard')
                    <!-- Keyboard/Piano SVG Icon - Clean Silhouette -->
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="3" y="6" width="18" height="12" rx="1" stroke="currentColor" stroke-width="1.5" fill="none"/>
                        <rect x="4" y="8" width="2.5" height="8" fill="currentColor" opacity="0.2"/>
                        <rect x="7.5" y="8" width="2.5" height="8" fill="currentColor" opacity="0.2"/>
                        <rect x="11" y="8" width="2.5" height="8" fill="currentColor" opacity="0.2"/>
                        <rect x="14.5" y="8" width="2.5" height="8" fill="currentColor" opacity="0.2"/>
                        <rect x="18" y="8" width="2.5" height="8" fill="currentColor" opacity="0.2"/>
                        <rect x="5.25" y="8" width="1.5" height="5" fill="currentColor"/>
                        <rect x="8.75" y="8" width="1.5" height="5" fill="currentColor"/>
                        <rect x="12.25" y="8" width="1.5" height="5" fill="currentColor"/>
                        <rect x="15.75" y="8" width="1.5" height="5" fill="currentColor"/>
                        <rect x="19.25" y="8" width="1.5" height="5" fill="currentColor"/>
                    </svg>
                @elseif($iconType === 'drum')
                    <!-- Drums SVG Icon - Clean Silhouette -->
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="12" r="8" stroke="currentColor" stroke-width="1.5" fill="none"/>
                        <circle cx="12" cy="12" r="5" stroke="currentColor" stroke-width="1" fill="none" opacity="0.5"/>
                        <line x1="4" y1="12" x2="8" y2="12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        <line x1="16" y1="12" x2="20" y2="12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        <line x1="12" y1="4" x2="12" y2="8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        <line x1="12" y1="16" x2="12" y2="20" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        <circle cx="12" cy="12" r="1.5" fill="currentColor"/>
                    </svg>
                @elseif($iconType === 'wind')
                    <!-- Wind Instrument (Saxophone) SVG Icon - Clean Silhouette -->
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8 4c0-1.1.9-2 2-2h4c1.1 0 2 .9 2 2v16c0 1.1-.9 2-2 2h-4c-1.1 0-2-.9-2-2V4z" stroke="currentColor" stroke-width="1.5" fill="none"/>
                        <path d="M10 4v16" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        <circle cx="7" cy="8" r="1" fill="currentColor"/>
                        <circle cx="7" cy="12" r="1" fill="currentColor"/>
                        <circle cx="7" cy="16" r="1" fill="currentColor"/>
                        <path d="M14 8l4-4M14 12l4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                @elseif($iconType === 'string')
                    <!-- String Instrument (Violin) SVG Icon - Clean Silhouette -->
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2C8.13 2 5 5.13 5 9c0 2.38 1.19 4.47 3 5.74V17c0 .55.45 1 1 1h6c.55 0 1-.45 1-1v-2.26c1.81-1.27 3-3.36 3-5.74 0-3.87-3.13-7-7-7z" stroke="currentColor" stroke-width="1.5" fill="none"/>
                        <path d="M9 9c0-1.66 1.34-3 3-3s3 1.34 3 3" stroke="currentColor" stroke-width="1.5" fill="none"/>
                        <line x1="12" y1="4" x2="12" y2="8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        <line x1="12" y1="16" x2="12" y2="20" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        <line x1="8" y1="12" x2="16" y2="12" stroke="currentColor" stroke-width="1" stroke-linecap="round" opacity="0.5"/>
                        <circle cx="10" cy="9" r="0.5" fill="currentColor"/>
                        <circle cx="14" cy="9" r="0.5" fill="currentColor"/>
                    </svg>
                @else
                    <!-- Music/Accessory SVG Icon - Clean Silhouette -->
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="9" cy="18" r="3" stroke="currentColor" stroke-width="1.5" fill="none"/>
                        <circle cx="18" cy="16" r="3" stroke="currentColor" stroke-width="1.5" fill="none"/>
                        <path d="M9 18V5l9-2v13" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
                        <line x1="9" y1="15" x2="18" y2="13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                @endif
            </div>
            <h5 class="card-title mb-2">{{ $category->name }}</h5>
            <p class="text-muted small mb-0">{{ $category->products_count ?? $category->products()->count() }} products</p>
        </div>
    </div>
</a>
