@props([
    'variant' => 'overlay', // 'overlay' or 'standard'
    'class' => '',
])

@php
    $isOverlay = $variant === 'overlay';
    $headerClasses = $isOverlay
        ? 'absolute left-0 right-0 z-50'
        : 'relative bg-white border-b border-neutral-200 z-50';
    $textClasses = $isOverlay ? 'text-white' : 'text-neutral-900';
    $logoVariant = $isOverlay ? 'light' : 'dark';
    $mobileBackgroundClasses = $isOverlay
        ? 'bg-black bg-opacity-90 backdrop-blur-sm'
        : 'bg-white border-t border-neutral-200';
@endphp

<header class="{{ $headerClasses }} {{ $class }}" x-data="{ mobileMenuOpen: false }">
    <div class="container-public">
        <div class="flex h-20 items-center justify-between">
            <!-- Logo -->
            <div class="flex flex-shrink-0 items-center">
                <x-logo size="xl" :link="true" :variant="$logoVariant" />
            </div>

            <!-- Desktop Navigation -->
            <nav class="hidden md:flex md:items-center md:gap-6">
                <x-nav-item href="{{ route('home') }}" class="{{ $textClasses }}">
                    Home
                </x-nav-item>

                <x-nav-item href="{{ route('cars.index') }}" class="{{ $textClasses }}">
                    Cars
                </x-nav-item>

                <x-nav-item href="{{ route('contact') }}" class="{{ $textClasses }}">
                    Contact
                </x-nav-item>
            </nav>

            <!-- Mobile Menu & Contact Button -->
            <div class="flex items-center gap-4">
                <!-- Contact Button -->
                <div class="hidden md:block">
                    <x-keys::button variant="brand" size="sm" href="tel:{{ setting('contact_phone') }}">
                        Call Now
                    </x-keys::button>
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden">
                    <x-keys::button
                        variant="ghost"
                        size="sm"
                        icon=""
                        class="{{ $textClasses }} hover:{{ $isOverlay ? 'text-white' : 'text-neutral-700' }}"
                        @click="mobileMenuOpen = !mobileMenuOpen"
                        ::aria-expanded="mobileMenuOpen" />
                </div>
            </div>
        </div>

        <!-- Mobile Navigation -->
        <div class="md:hidden"
             x-show="mobileMenuOpen"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             style="display: none;">
            <div class="{{ $mobileBackgroundClasses }} py-3">
                <div class="container-public">
                <nav class="space-y-1">
                    <x-nav-item href="{{ route('home') }}" :mobile="true" class="{{ $textClasses }}">
                        {{ __('Home') }}
                    </x-nav-item>

                    <x-nav-item href="{{ route('cars.index') }}" :mobile="true" class="{{ $textClasses }}">
                        {{ __('Cars') }}
                    </x-nav-item>

                    <x-nav-item href="{{ route('contact') }}" :mobile="true" class="{{ $textClasses }}">
                        {{ __('Contact') }}
                    </x-nav-item>

                    <!-- Mobile Contact Button -->
                    <div class="pt-3">
                        <x-keys::button
                            variant="brand"
                            size="md"
                            href="tel:{{ setting('contact_phone') }}"
                            class="w-full justify-center">
                            {{ __('Call Now') }}
                        </x-keys::button>
                    </div>
                </nav>
                </div>
            </div>
        </div>
    </div>
</header>

