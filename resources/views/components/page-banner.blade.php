@props([
    'title' => __('Browse Our Collection'),
    'description' => __('Discover premium vehicles from our curated selection of luxury cars ready for export'),
    'backgroundImage' => 'https://images.unsplash.com/photo-1449824913935-59a10b8d2000',
    'stats' => [],
    'class' => '',
])

<!-- Minimal Page Banner -->
<section class="relative bg-neutral-900 overflow-hidden {{ $class }}">
    <!-- Background Image with Overlay -->
    @if($backgroundImage)
        <img src="{{ $backgroundImage }}"
             alt="{{ __('Page banner background') }}"
             class="absolute inset-0 w-full h-full object-cover opacity-15">
    @endif

    <!-- Gradient Overlay -->
    <div class="absolute inset-0 bg-gradient-to-br from-black/70 via-black/50 to-transparent"></div>

    <!-- Content Container -->
    <div class="relative z-10 container-public pt-24 pb-12 md:pt-28 md:pb-16">
        <div class="max-w-4xl">
            <!-- Header Content -->
            <div class="mb-8">
                <!-- Page Title -->
                <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold text-white mb-3 font-helvetica">
                    {{ $title }}
                </h1>

                <!-- Description -->
                <p class="text-base md:text-lg text-white max-w-2xl font-helvetica font-light">
                    {{ $description }}
                </p>
            </div>

            <!-- Stats Section -->
            @if(count($stats) > 0)
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
                    @foreach($stats as $stat)
                        <div class="relative group">
                            <!-- Background Icon -->
                            @if(isset($stat['icon']))
                                <div class="absolute -top-2 -left-2 opacity-10 group-hover:opacity-20 transition-opacity">
                                    <x-keys::icon :name="$stat['icon']" size="2xl" class="text-white" />
                                </div>
                            @endif

                            <!-- Content -->
                            <div class="relative z-10">
                                <!-- Value -->
                                <div class="text-xl md:text-2xl font-bold text-white mb-1 font-helvetica">
                                    {{ $stat['value'] }}
                                </div>

                                <!-- Label -->
                                <div class="text-xs md:text-sm text-white/70 font-helvetica font-light">
                                    {{ $stat['label'] }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</section>