@props(['items' => []])

@if(!empty($items))
<nav aria-label="breadcrumb" class="breadcrumb-nav">
    <div class="container">
        <ol class="breadcrumb mb-0 py-2">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Home</a>
            </li>
            @foreach($items as $item)
                @if(isset($item['url']))
                    <li class="breadcrumb-item">
                        <a href="{{ $item['url'] }}">{{ $item['label'] }}</a>
                    </li>
                @else
                    <li class="breadcrumb-item active" aria-current="page">{{ $item['label'] }}</li>
                @endif
            @endforeach
        </ol>
    </div>
</nav>
@endif

