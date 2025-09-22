@props([
    'overline' => '',
    'heading' => '',
    'description' => '',
    'alignment' => 'center', // 'left', 'center', 'right'
    'class' => ''
])

@php
    $alignmentClasses = match($alignment) {
        'left' => 'text-left items-start',
        'right' => 'text-right items-end',
        default => 'text-center items-center'
    };
@endphp

<div class="flex flex-col {{ $alignmentClasses }} {{ $class }}">
    <!-- Luxury Overline -->
    @if($overline)
        <div class="flex items-center mb-4 space-x-4 luxury-slide-in {{ $alignment === 'center' ? 'justify-center' : ($alignment === 'left' ? 'justify-start' : 'justify-end') }}">
            <div class="w-8 h-[1px] bg-neutral-300"></div>
            <span class="text-neutral-600 text-sm tracking-[0.2em] uppercase font-helvetica font-light">
                {{ $overline }}
            </span>
            <div class="w-8 h-[1px] bg-neutral-300"></div>
        </div>
    @endif

    <!-- Luxury Main Heading -->
    <h2 class="text-4xl md:text-5xl xl:text-6xl font-light text-neutral-900 font-helvetica mb-4 luxury-fade-in">
        {{ $heading }}
    </h2>

    <!-- Enhanced Description -->
    @if($description)
        <p class="text-xl text-neutral-700 font-helvetica font-light leading-relaxed {{ $alignment === 'center' ? 'container-text' : 'max-w-3xl' }} luxury-fade-in">
            {{ $description }}
        </p>
    @endif
</div>