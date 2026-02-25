<div class="card property-card" id="property-{{ $property->id }}">
    <div class="property-badge">
        <span class="price bg-success">₦ {{ number_format($property->price_per_night, 2) }}</span>
    </div>
    <img src="{{ asset('storage/' . $property->image_path) }}" alt="{{ $property->name }}" class="card-img-top">
    <div class="card-body">
        <h5 class="card-title">{{ $property->name }}</h5>
        <p class="card-text">{{ $property->address }}, {{ $property->city }}</p>
        <div class="card-text buttons d-flex gap-2">
            <a href="javascript:void(0);"
                class="icons bookmark-btn {{ (isset($isBookmarked) && $isBookmarked) || (auth()->check() && auth()->user()->bookmarkedProperties()->where('property_id', $property->id)->exists()) ? 'bookmarked text-warning' : '' }}"
                onclick="toggleBookmark('{{ $property->id }}', this)" title="Bookmark Property">
                <i
                    class="bi {{ (isset($isBookmarked) && $isBookmarked) || (auth()->check() && auth()->user()->bookmarkedProperties()->where('property_id', $property->id)->exists()) ? 'bi-bookmark-fill' : 'bi-bookmark' }}"></i>
            </a>

            @if(auth()->check() && auth()->user()->hasRole('Admin'))
                <a href="/book/property/{{$property->id}}" class="icons plus" title="Book Property">
                    <i class="bi bi-plus-lg"></i>
                </a>
                <a href="{{ route('properties.show', $property->id) }}" class="icons eye" title="View Details">
                    <i class="bi bi-eye"></i>
                </a>
            @else
                <a href="/book/property/{{$property->id}}" class="icons plus">
                    <i class="bi bi-plus-lg"></i>
                </a>
                <a href="{{ route('properties.show', $property->id) }}" class="icons eye">
                    <i class="bi bi-eye"></i>
                </a>
            @endif
        </div>
    </div>
</div>