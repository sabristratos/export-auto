@props([
    'make',
    'size' => 'medium', // thumb, medium, large
    'class' => ''
])

<a href="{{ route('cars.index', ['make' => $make->slug]) }}"
   class="group flex items-center justify-center {{ $class }}"
   title="{{ __('View') }} {{ $make->name }} {{ __('cars') }}">
    @if($make->hasLogo())
        <img
            src="{{ $make->getLogoUrl() }}"
            alt="{{ $make->name }} logo"
            class="partner-logo-filter max-w-full max-h-20 w-auto h-auto object-contain group-hover:scale-110 transition-transform duration-300"
            loading="lazy"
        >
    @else
        <!-- Fallback for missing logo -->
        <div class="flex items-center justify-center w-full h-20 text-neutral-400 font-helvetica font-light text-lg group-hover:text-brand-600 transition-colors">
            {{ $make->name }}
        </div>
    @endif
</a>