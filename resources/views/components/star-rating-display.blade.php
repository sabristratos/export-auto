@props([
    'rating' => 0,
    'maxRating' => 5,
    'size' => 'md', // sm, md, lg
    'showValue' => false,
    'class' => ''
])

@php
    $sizeClasses = match($size) {
        'sm' => 'w-4 h-4',
        'lg' => 'w-6 h-6',
        default => 'w-5 h-5'
    };

    $rating = max(0, min($maxRating, $rating));
    $fullStars = floor($rating);
    $hasHalfStar = ($rating - $fullStars) >= 0.5;
    $emptyStars = $maxRating - $fullStars - ($hasHalfStar ? 1 : 0);
@endphp

<div class="flex items-center space-x-2 {{ $class }}">
    <div class="flex items-center space-x-1">
        {{-- Full Stars --}}
        @for($i = 0; $i < $fullStars; $i++)
            <svg class="{{ $sizeClasses }} text-yellow-400 fill-current" viewBox="0 0 20 20">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
            </svg>
        @endfor

        {{-- Half Star --}}
        @if($hasHalfStar)
            <div class="relative {{ $sizeClasses }}">
                <svg class="{{ $sizeClasses }} text-neutral-300 fill-current absolute" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
                <svg class="{{ $sizeClasses }} text-yellow-400 fill-current" viewBox="0 0 20 20" style="clip-path: inset(0 50% 0 0);">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
            </div>
        @endif

        {{-- Empty Stars --}}
        @for($i = 0; $i < $emptyStars; $i++)
            <svg class="{{ $sizeClasses }} text-neutral-300 fill-current" viewBox="0 0 20 20">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
            </svg>
        @endfor
    </div>

    @if($showValue)
        <span class="text-sm font-medium text-neutral-600 font-helvetica">
            {{ number_format($rating, 1) }}/{{ $maxRating }}
        </span>
    @endif
</div>