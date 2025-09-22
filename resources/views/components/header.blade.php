@props([
    'class' => '',
])

<header class="absolute top-0 left-0 right-0 z-50 {{ $class }}" x-data="{ mobileMenuOpen: false }">
    <div class="w-full">
        <div class="flex h-20 items-center justify-between px-6 lg:px-8">
            <!-- Logo -->
            <div class="flex flex-shrink-0 items-center">
                <x-logo size="lg" :link="true" />
            </div>

            <!-- Desktop Navigation -->
            <nav class="hidden md:flex md:items-center md:gap-6">
                <x-nav-item href="{{ route('home') }}" class="text-white">
                    Home
                </x-nav-item>

                <x-nav-item href="#" class="text-white">
                    Cars
                </x-nav-item>

                <x-nav-item href="#" class="text-white">
                    About
                </x-nav-item>

                <x-nav-item href="#" class="text-white">
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
                        class="text-white hover:text-white"
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
            <div class="bg-black bg-opacity-90 backdrop-blur-sm px-6 py-3">
                <nav class="space-y-1">
                    <x-nav-item href="{{ route('home') }}" :mobile="true" class="text-white">
                        {{ __('Home') }}
                    </x-nav-item>

                    <x-nav-item href="#" :mobile="true" class="text-white">
                        {{ __('Cars') }}
                    </x-nav-item>

                    <x-nav-item href="#" :mobile="true" class="text-white">
                        {{ __('About') }}
                    </x-nav-item>

                    <x-nav-item href="#" :mobile="true" class="text-white">
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
</header>

