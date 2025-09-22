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
        <div class="flex items-center mb-4">
            @if($alignment === 'left')
                <div class="w-8 h-[1px] bg-brand-600/60 mr-4"></div>
            @elseif($alignment === 'right')
                <div class="w-8 h-[1px] bg-brand-600/60 mr-4"></div>
            @else
                <div class="flex-1 h-[1px] bg-gradient-to-r from-transparent via-brand-300 to-brand-600"></div>
            @endif

            <span class="!text-brand-600 text-sm font-bold tracking-[0.2em] uppercase font-helvetica font-light">
                {{ $overline }}
            </span>

            @if($alignment === 'center')
                <div class="flex-1 h-[1px] bg-gradient-to-r from-brand-600 via-brand-300 to-transparent"></div>
            @endif
        </div>
    @endif

    <!-- Luxury Main Heading -->
    <div class="relative inline-block mb-10">
        <h2 class="!text-neutral-900 text-5xl md:text-6xl lg:text-7xl font-bold font-helvetica leading-[0.9] tracking-tight">
            {{ $heading }}
        </h2>

        <!-- Nav-Style Decorative Underline Elements -->
        <div class="absolute -bottom-4 left-0 w-full flex justify-{{ $alignment === 'center' ? 'center' : ($alignment === 'left' ? 'start' : 'end') }}">
            <div class="relative w-32 md:w-40">
                <!-- Main underline (80% width, left-aligned) -->
                <div class="absolute bottom-0 left-0 w-[80%] h-[4px] bg-brand-600 -skew-x-[25deg] transform"></div>

                <!-- Detached accent underline (12% width, right-aligned) -->
                <div class="absolute bottom-0 right-0 w-[12%] h-[4px] bg-brand-600 -skew-x-[25deg] transform"></div>
            </div>
        </div>
    </div>

    <!-- Enhanced Description -->
    @if($description)
        <p class="!text-neutral-600 text-xl md:text-2xl leading-relaxed font-helvetica font-light max-w-4xl">
            {{ $description }}
        </p>
    @endif
</div>