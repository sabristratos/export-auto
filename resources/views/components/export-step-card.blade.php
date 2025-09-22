@props([
    'step' => 1,
    'title' => '',
    'description' => '',
    'icon' => 'search',
    'class' => '',
    'style' => ''
])

@php
    // Luxury automotive background images for each step
    $backgroundImages = [
        'search' => 'https://images.unsplash.com/photo-1519641471654-76ce0107ad1b?q=80&w=1171&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        'document' => 'https://plus.unsplash.com/premium_photo-1661880595669-2b0f7e2da693?q=80&w=1074&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        'shipping' => 'https://images.unsplash.com/photo-1605745341112-85968b19335b?q=80&w=1171&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        'delivery' => 'https://images.unsplash.com/photo-1533558701576-23c65e0272fb?q=80&w=687&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'
    ];

    $backgroundImage = $backgroundImages[$icon] ?? $backgroundImages['search'];
@endphp

<div class="group relative h-80 rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-700 {{ $class }}" style="{{ $style }}">
    <!-- Full Background Image -->
    <div class="absolute inset-0 bg-cover bg-center bg-no-repeat group-hover:scale-105 transition-transform duration-700"
         style="background-image: url('{{ $backgroundImage }}');">
    </div>

    <!-- Minimal Overlay -->
    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/10 to-transparent group-hover:from-black/60 transition-all duration-700"></div>

    <!-- Step Number Badge -->
    <div class="absolute top-6 right-6 w-12 h-12 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center font-bold text-lg !text-white shadow-lg">
        {{ $step }}
    </div>

    <!-- Content at Bottom -->
    <div class="absolute bottom-0 left-0 right-0 p-4">
        <h3 class="!text-white text-xl font-bold font-helvetica leading-tight">
            {{ $title }}
        </h3>

        <p class="!text-white/90 text-sm leading-relaxed font-helvetica font-light">
            {{ $description }}
        </p>
    </div>
</div>
