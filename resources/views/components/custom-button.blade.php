@props([
    'variant' => 'primary',
    'size' => 'md',
    'href' => null,
    'type' => 'button',
    'disabled' => false,
    'class' => '',
])

@php
    // Base classes for the custom button with sliding skewed background
    $baseClasses = 'relative font-bold border-2 cursor-pointer inline-block overflow-hidden font-helvetica transition-all duration-300 z-10
                    before:content-[""] before:absolute before:top-0 before:left-0 before:w-[120%] before:h-full before:z-[1] before:transition-transform before:duration-300 before:ease-out';

    // Variant classes
    $variantClasses = match($variant) {
        'primary' => 'border-brand-600 !text-white bg-brand-600 hover:!text-white hover:border-brand-700 before:bg-brand-700 before:translate-x-[-110%] before:-skew-x-[25deg] hover:before:translate-x-[-10%]',
        'secondary' => 'border-white !text-white hover:!text-neutral-900 hover:border-white before:bg-white before:translate-x-[-110%] before:-skew-x-[25deg] hover:before:translate-x-[-10%]',
        'outline' => 'border-brand-600 text-brand-600 hover:text-white hover:border-brand-600 before:bg-brand-600 before:translate-x-[-110%] before:-skew-x-[25deg] hover:before:translate-x-[-10%]',
        'ghost' => 'border-neutral-300 text-neutral-700 hover:text-brand-600 hover:border-brand-300 before:bg-brand-50 before:translate-x-[-110%] before:-skew-x-[25deg] hover:before:translate-x-[-10%]',
        'danger' => 'border-red-600 text-red-600 hover:text-white hover:border-red-600 before:bg-red-600 before:translate-x-[-110%] before:-skew-x-[25deg] hover:before:translate-x-[-10%]',
        'white' => 'border-white text-white hover:text-neutral-900 hover:border-white before:bg-white before:translate-x-[-110%] before:-skew-x-[25deg] hover:before:translate-x-[-10%]',
        default => 'border-brand-600 text-brand-600 hover:text-white hover:border-brand-600 before:bg-brand-600 before:translate-x-[-110%] before:-skew-x-[25deg] hover:before:translate-x-[-10%]'
    };

    // Size classes
    $sizeClasses = match($size) {
        'sm' => 'text-sm px-4 py-2',
        'md' => 'text-lg px-6 py-3',
        'lg' => 'text-xl px-8 py-4',
        default => 'text-lg px-6 py-3'
    };

    $classes = implode(' ', array_filter([$baseClasses, $variantClasses, $sizeClasses, $class]));
@endphp

@if($href)
    <a href="{{ $href }}"
       class="{{ $classes }}"
       @if($disabled) aria-disabled="true" @endif>
        <span class="relative z-20">{{ $slot }}</span>
    </a>
@else
    <button type="{{ $type }}"
            class="{{ $classes }}"
            @if($disabled) disabled @endif>
        <span class="relative z-20">{{ $slot }}</span>
    </button>
@endif