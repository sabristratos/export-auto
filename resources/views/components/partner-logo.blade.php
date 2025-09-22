@props([
    'make',
    'size' => 'medium', // thumb, medium, large
    'class' => ''
])

<div class="group flex items-center justify-center {{ $class }}">
    @if($make->hasLogo())
        <img
            src="{{ $make->getLogoUrl() }}"
            alt="{{ $make->name }} logo"
            class="max-w-full max-h-20 w-auto h-auto object-contain transition-all duration-500 group-hover:scale-110"
            loading="lazy"
        >
    @else
        <!-- Fallback for missing logo -->
        <div class="flex items-center justify-center w-full h-20 text-neutral-400 font-helvetica font-light text-lg">
            {{ $make->name }}
        </div>
    @endif
</div>