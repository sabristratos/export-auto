<div>
    @if($this->cars->count() > 0)
        <!-- Cars Grid -->
        <div class="grid grid-cols-[repeat(auto-fit,minmax(320px,1fr))] gap-4">
            @foreach($this->cars as $car)
                <x-car-card :car="$car" />
            @endforeach
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-20">
            <div class="text-neutral-400 mb-4">
                <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21l-7-5-7 5V5a2 2 0 012-2h10a2 2 0 012 2v16z"/>
                </svg>
            </div>
            <h3 class="text-xl font-medium text-neutral-900 mb-2">{{ __('No Featured Cars Available') }}</h3>
            <p class="text-neutral-600">{{ __('Our premium collection is being updated. Please check back soon.') }}</p>
        </div>
    @endif
</div>
