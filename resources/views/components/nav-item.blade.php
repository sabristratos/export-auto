@props([
    'href' => '#',
    'active' => false,
    'mobile' => false,
    'class' => '',
])

@php
    // Determine if this navigation item is active
    $isActive = $active || ($href !== '#' && request()->url() === url($href));

    // Special case: Make Cars nav active for any car-related page
    if (!$isActive && $href === route('cars.index')) {
        $isActive = request()->routeIs('cars.*');
    }

    // Check if white text is requested
    $isWhiteText = str_contains($class, 'text-white');

    // Base classes for the navigation item
    $baseClasses = $mobile
        ? 'block w-full text-left px-0 py-3 text-base font-medium ' . ($isWhiteText ? '!text-white hover:!text-white/70' : 'text-neutral-700 hover:text-brand-600') . ' transition-colors duration-300 font-helvetica'
        : 'relative inline-block px-3 py-2 font-medium transition-colors duration-300 font-helvetica ' . ($isWhiteText ? '!text-white hover:!text-white/70' : 'text-neutral-700 hover:text-brand-600') . '
           after:content-[""] after:absolute after:bottom-0 after:left-0 after:w-[80%] after:h-1 after:bg-brand-600 after:-skew-x-[25deg] after:opacity-0 after:transition-all after:duration-300
           before:content-[""] before:absolute before:bottom-0 before:right-0 before:w-[12%] before:h-1 before:bg-brand-600 before:-skew-x-[25deg] before:opacity-0 before:transition-all before:duration-300
           hover:after:opacity-100 hover:after:scale-x-105 hover:before:opacity-100 hover:before:scale-x-105';

    // Add active class if needed
    $activeClasses = $isActive && !$mobile
        ? ' text-brand-600 after:opacity-100 after:scale-x-105 before:opacity-100 before:scale-x-105'
        : '';
    $classes = $baseClasses . $activeClasses . ' ' . $class;
@endphp

@if($mobile)
    {{-- Mobile navigation item (no skewed effect) --}}
    <a href="{{ $href }}"
       class="{{ $classes }}"
       @if($isActive) aria-current="page" @endif>
        {{ $slot }}
    </a>
@else
    {{-- Desktop navigation item with skewed underline effect --}}
    <a href="{{ $href }}"
       class="{{ $classes }}"
       @if($isActive) aria-current="page" @endif>
        {{ $slot }}
    </a>
@endif