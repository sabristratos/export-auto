<x-layouts.app>
    <div class="min-h-screen bg-neutral-50">
        <!-- Page Header -->
        <div class="bg-white border-b border-neutral-200">
            <div class="container-search py-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-neutral-900 font-helvetica">
                            Search Results
                        </h1>
                        <p class="mt-2 text-neutral-600 font-helvetica">
                            Find your perfect car from our premium collection
                        </p>
                    </div>
                    <div class="mt-4 md:mt-0">
                        <a href="{{ route('home') }}"
                           class="inline-flex items-center gap-2 text-brand-600 hover:text-brand-700 transition-colors duration-200">
                            @svg('heroicon-o-arrow-left', ['class' => 'w-4 h-4'])
                            Back to Home
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search Results Content -->
        <div class="container-search py-8">
            <livewire:car-search-results-component />
        </div>
    </div>
</x-layouts.app>