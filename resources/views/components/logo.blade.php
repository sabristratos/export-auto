@props([
    'size' => 'md',
    'link' => false,
    'showText' => false,
    'conversion' => null,
    'class' => '',
    'alt' => null,
    'variant' => 'light', // 'light' or 'dark'
])

@php
    $logoUrl = setting_file('site_logo', $conversion);
    $siteName = setting('site_name', 'Elite Car Export');
    $defaultLogo = asset('elite-cars-logo.png');

    // Use default logo if no setting is configured
    $imageUrl = $logoUrl ?: $defaultLogo;
    $altText = $alt ?: $siteName;

    // Size variants
    $sizeClasses = [
        'xs' => 'h-8 w-auto',
        'sm' => 'h-10 w-auto',
        'md' => 'h-12 w-auto',
        'lg' => 'h-16 w-auto',
        'xl' => 'h-20 w-auto',
        '2xl' => 'h-24 w-auto',
    ];

    // Text size variants for text logo
    $textSizeClasses = [
        'xs' => 'text-lg font-bold',
        'sm' => 'text-xl font-bold',
        'md' => 'text-2xl font-bold',
        'lg' => 'text-3xl font-bold',
        'xl' => 'text-4xl font-bold',
        '2xl' => 'text-5xl font-bold',
    ];

    $logoSizeClass = $sizeClasses[$size] ?? $sizeClasses['md'];
    $textSizeClass = $textSizeClasses[$size] ?? $textSizeClasses['md'];

    // Color variants
    $isLight = $variant === 'light';
    $imageColorClasses = $isLight ? 'brightness-0 invert' : '';
    $textColorClasses = $isLight ? 'text-white' : 'text-neutral-900';

    $logoClasses = $logoSizeClass . ' ' . $imageColorClasses . ' ' . $class;
@endphp

@if($link)
    <a href="{{ route('home') }}" class="inline-flex items-center gap-3 rtl:gap-3 rtl:flex-row-reverse">
        @if($imageUrl && !$showText)
            <img src="{{ $imageUrl }}"
                 alt="{{ $altText }}"
                 class="{{ $logoClasses }}"
                 loading="lazy">
        @elseif($showText || !$imageUrl)
            <span class="{{ $textSizeClass }} {{ $textColorClasses }} font-helvetica">
                {{ $siteName }}
            </span>
        @endif

        @if($showText && $imageUrl)
            <span class="{{ $textSizeClass }} {{ $textColorClasses }} font-helvetica">
                {{ $siteName }}
            </span>
        @endif
    </a>
@else
    <div class="inline-flex items-center gap-3 rtl:gap-3 rtl:flex-row-reverse">
        @if($imageUrl && !$showText)
            <img src="{{ $imageUrl }}"
                 alt="{{ $altText }}"
                 class="{{ $logoClasses }}"
                 loading="lazy">
        @elseif($showText || !$imageUrl)
            <span class="{{ $textSizeClass }} {{ $textColorClasses }} font-helvetica">
                {{ $siteName }}
            </span>
        @endif

        @if($showText && $imageUrl)
            <span class="{{ $textSizeClass }} {{ $textColorClasses }} font-helvetica">
                {{ $siteName }}
            </span>
        @endif
    </div>
@endif