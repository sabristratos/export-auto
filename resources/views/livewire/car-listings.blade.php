<div>
    <!-- Main Content -->
    <div class="bg-neutral-50 min-h-screen py-12">
        <div class="container-public">
            <!-- Mobile Layout: Single Column -->
            <div class="lg:hidden">
                <!-- Results Section Mobile -->
                <div>
                    <!-- Results Header -->
                    <div class="bg-white rounded-lg p-6 mb-6">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <!-- Results Count -->
                            <div class="flex items-center space-x-4">
                                <h3 class="text-lg font-semibold text-neutral-900">
                                    {{ __('Results') }}
                                </h3>
                                <span class="text-sm text-neutral-600">
                                    {{ __(':total cars found', ['total' => $cars->total()]) }}
                                </span>
                            </div>

                            <!-- Sort Options -->
                            <div class="flex items-center space-x-4">
                                <span class="text-sm text-neutral-600">{{ __('Sort by:') }}</span>
                                @php
                                    $currentSortValue = match(true) {
                                        $sortBy === 'price' && $sortDirection === 'asc' => 'price_asc',
                                        $sortBy === 'price' && $sortDirection === 'desc' => 'price_desc',
                                        $sortBy === 'featured' => 'featured',
                                        default => 'created_at'
                                    };
                                @endphp

                                <div class="min-w-48">
                                <x-keys::select
                                    name="sortBy"
                                    wire:model.live="sortBy"
                                    size="sm"
                                    :value="$currentSortValue"
                                >
                                    <x-keys::select.option value="created_at" :label="__('Newest First')" />
                                    <x-keys::select.option value="price_asc" :label="__('Price: Low to High')" />
                                    <x-keys::select.option value="price_desc" :label="__('Price: High to Low')" />
                                    <x-keys::select.option value="featured" :label="__('Featured First')" />
                                </x-keys::select>
                                </div>
                            </div>
                        </div>

                        <!-- Active Filters -->
                        @if($search || $selectedMake || $selectedModel || $minPrice || $maxPrice || $selectedYear || $selectedFuelType || $selectedTransmission || $minMileage || $maxMileage || $featuredOnly)
                            <div class="mt-4 pt-4 border-t border-neutral-200">
                                <div class="flex flex-wrap gap-2">
                                    <span class="text-sm text-neutral-600">{{ __('Active filters:') }}</span>

                                    @if($search)
                                        <x-keys::badge variant="outline" color="neutral" size="sm">
                                            {{ __('Search: :term', ['term' => $search]) }}
                                            <x-keys::icon name="heroicon-o-x-mark" size="xs" class="ml-1 cursor-pointer" wire:click="$set('search', '')" />
                                        </x-keys::badge>
                                    @endif

                                    @if($featuredOnly)
                                        <x-keys::badge variant="outline" color="brand" size="sm">
                                            {{ __('Featured Only') }}
                                            <x-keys::icon name="heroicon-o-x-mark" size="xs" class="ml-1 cursor-pointer" wire:click="$set('featuredOnly', false)" />
                                        </x-keys::badge>
                                    @endif

                                    @if($selectedMake)
                                        <x-keys::badge variant="outline" color="neutral" size="sm">
                                            {{ $makes->firstWhere('id', $selectedMake)?->name }}
                                            <x-keys::icon name="heroicon-o-x-mark" size="xs" class="ml-1 cursor-pointer" wire:click="$set('selectedMake', '')" />
                                        </x-keys::badge>
                                    @endif

                                    @if($selectedModel)
                                        <x-keys::badge variant="outline" color="neutral" size="sm">
                                            {{ $models->firstWhere('id', $selectedModel)?->name }}
                                            <x-keys::icon name="heroicon-o-x-mark" size="xs" class="ml-1 cursor-pointer" wire:click="$set('selectedModel', '')" />
                                        </x-keys::badge>
                                    @endif

                                    @if($selectedFuelType)
                                        @php
                                            $fuelBadgeColor = match(strtolower($selectedFuelType)) {
                                                'electric' => 'success',
                                                'hybrid', 'plug-in hybrid' => 'info',
                                                'diesel' => 'neutral',
                                                'gasoline' => 'warning',
                                                default => 'neutral'
                                            };
                                        @endphp
                                        <x-keys::badge variant="solid" :color="$fuelBadgeColor" size="sm">
                                            {{ $selectedFuelType }}
                                            <x-keys::icon name="heroicon-o-x-mark" size="xs" class="ml-1 cursor-pointer" wire:click="$set('selectedFuelType', '')" />
                                        </x-keys::badge>
                                    @endif

                                    @if($minPrice || $maxPrice)
                                        <x-keys::badge variant="outline" color="neutral" size="sm">
                                            {{ __('Price: €:min - €:max', ['min' => $minPrice ?: '0', 'max' => $maxPrice ?: '∞']) }}
                                            <x-keys::icon name="heroicon-o-x-mark" size="xs" class="ml-1 cursor-pointer" wire:click="$set('minPrice', ''); $set('maxPrice', '')" />
                                        </x-keys::badge>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Cars Grid Mobile -->
                    @if($cars->count() > 0)
                        <div class="grid grid-cols-[repeat(auto-fit,minmax(320px,1fr))] gap-4 mb-8">
                            @foreach($cars as $car)
                                <x-car-card :car="$car" />
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="flex justify-center">
                            {{ $cars->links() }}
                        </div>
                    @else
                        <!-- Empty State -->
                        <x-keys::card class="text-center py-16">
                            <x-keys::icon name="heroicon-o-magnifying-glass" size="xl" class="text-neutral-400 mx-auto mb-4" />
                            <h3 class="text-lg font-semibold text-neutral-900 mb-2">
                                {{ __('No cars found') }}
                            </h3>
                            <p class="text-neutral-600 mb-6">
                                {{ __('Try adjusting your filters or search terms to find more results.') }}
                            </p>
                            <x-keys::button
                                variant="brand"
                                wire:click="clearFilters"
                            >
                                {{ __('Clear All Filters') }}
                            </x-keys::button>
                        </x-keys::card>
                    @endif
                </div>
            </div>

            <!-- Desktop Layout: Sidebar + Content -->
            <div class="hidden lg:grid lg:grid-cols-4 gap-6">
                <!-- Filters Sidebar -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg p-6 sticky top-8">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-lg font-semibold text-neutral-900">{{ __('Filter Cars') }}</h2>
                            @if($search || $selectedMake || $selectedModel || $minPrice || $maxPrice || $selectedYear || $selectedFuelType || $selectedTransmission || $minMileage || $maxMileage || $featuredOnly)
                                <x-keys::button
                                    variant="ghost"
                                    size="sm"
                                    wire:click="clearFilters"
                                    class="text-brand-600 hover:text-brand-700"
                                >
                                    {{ __('Clear All') }}
                                </x-keys::button>
                            @endif
                        </div>

                        <div class="space-y-6">
                            <!-- Search -->
                            <div>
                                <x-keys::input
                                    name="search"
                                    wire:model.live.debounce.300ms="search"
                                    :label="__('Search')"
                                    :placeholder="__('Search by make, model or description...')"
                                    icon-left="heroicon-o-magnifying-glass"
                                    clearable
                                    size="md"
                                />
                            </div>

                            <!-- Featured Only -->
                            <div>
                                <x-keys::checkbox
                                    name="featuredOnly"
                                    wire:model.live="featuredOnly"
                                    :label="__('Featured Cars Only')"
                                    size="md"
                                />
                            </div>

                            <!-- Make Filter -->
                            <div>
                                <x-keys::select
                                    name="selectedMake"
                                    wire:model.live="selectedMake"
                                    :label="__('Make')"
                                    :placeholder="__('All Makes')"
                                    size="md"
                                    clearable
                                >
                                    @foreach($makes as $make)
                                        <x-keys::select.option
                                            :value="$make->id"
                                            :label="$make->name . ' (' . $make->cars_count . ')'"
                                        />
                                    @endforeach
                                </x-keys::select>
                            </div>

                            <!-- Model Filter -->
                            @if($selectedMake && $models->count() > 0)
                                <div>
                                    <x-keys::select
                                        name="selectedModel"
                                        wire:model.live="selectedModel"
                                        :label="__('Model')"
                                        :placeholder="__('All Models')"
                                        size="md"
                                        clearable
                                    >
                                        @foreach($models as $model)
                                            <x-keys::select.option
                                                :value="$model->id"
                                                :label="$model->name . ' (' . $model->cars_count . ')'"
                                            />
                                        @endforeach
                                    </x-keys::select>
                                </div>
                            @endif

                            <!-- Price Range -->
                            <div>
                                <label class="block text-sm font-medium text-neutral-700 mb-3">{{ __('Price Range') }}</label>
                                <div class="grid grid-cols-2 gap-3">
                                    <x-keys::input
                                        name="minPrice"
                                        type="number"
                                        wire:model.live.debounce.500ms="minPrice"
                                        :placeholder="__('Min Price')"
                                        size="md"
                                    />
                                    <x-keys::input
                                        name="maxPrice"
                                        type="number"
                                        wire:model.live.debounce.500ms="maxPrice"
                                        :placeholder="__('Max Price')"
                                        size="md"
                                    />
                                </div>
                            </div>

                            <!-- Year Filter -->
                            @if($years->count() > 0)
                                <div>
                                    <x-keys::select
                                        name="selectedYear"
                                        wire:model.live="selectedYear"
                                        :label="__('Year')"
                                        :placeholder="__('Any Year')"
                                        size="md"
                                        clearable
                                    >
                                        @foreach($years->reverse() as $year)
                                            <x-keys::select.option :value="$year" :label="$year" />
                                        @endforeach
                                    </x-keys::select>
                                </div>
                            @endif

                            <!-- Fuel Type Filter -->
                            @if($fuelTypes->count() > 0)
                                <div>
                                    <x-keys::select
                                        name="selectedFuelType"
                                        wire:model.live="selectedFuelType"
                                        :label="__('Fuel Type')"
                                        :placeholder="__('Any Fuel Type')"
                                        size="md"
                                        clearable
                                    >
                                        @foreach($fuelTypes as $fuelType)
                                            <x-keys::select.option :value="$fuelType" :label="$fuelType" />
                                        @endforeach
                                    </x-keys::select>
                                </div>
                            @endif

                            <!-- Transmission Filter -->
                            @if($transmissions->count() > 0)
                                <div>
                                    <x-keys::select
                                        name="selectedTransmission"
                                        wire:model.live="selectedTransmission"
                                        :label="__('Transmission')"
                                        :placeholder="__('Any Transmission')"
                                        size="md"
                                        clearable
                                    >
                                        @foreach($transmissions as $transmission)
                                            <x-keys::select.option :value="$transmission" :label="$transmission" />
                                        @endforeach
                                    </x-keys::select>
                                </div>
                            @endif

                            <!-- Mileage Range -->
                            <div>
                                <label class="block text-sm font-medium text-neutral-700 mb-3">{{ __('Mileage Range (km)') }}</label>
                                <div class="grid grid-cols-2 gap-3">
                                    <x-keys::input
                                        name="minMileage"
                                        type="number"
                                        wire:model.live.debounce.500ms="minMileage"
                                        :placeholder="__('Min Mileage')"
                                        size="md"
                                    />
                                    <x-keys::input
                                        name="maxMileage"
                                        type="number"
                                        wire:model.live.debounce.500ms="maxMileage"
                                        :placeholder="__('Max Mileage')"
                                        size="md"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Results Section Desktop -->
                <div class="lg:col-span-3">
                    <!-- Results Header -->
                    <div class="bg-white rounded-lg p-6 mb-6">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <!-- Results Count -->
                            <div class="flex items-center space-x-4">
                                <h3 class="text-lg font-semibold text-neutral-900">
                                    {{ __('Results') }}
                                </h3>
                                <span class="text-sm text-neutral-600">
                                    {{ __(':total cars found', ['total' => $cars->total()]) }}
                                </span>
                            </div>

                            <!-- Sort Options -->
                            <div class="flex items-center space-x-4">
                                <span class="text-sm text-neutral-600">{{ __('Sort by:') }}</span>
                                @php
                                    $currentSortValue = match(true) {
                                        $sortBy === 'price' && $sortDirection === 'asc' => 'price_asc',
                                        $sortBy === 'price' && $sortDirection === 'desc' => 'price_desc',
                                        $sortBy === 'featured' => 'featured',
                                        default => 'created_at'
                                    };
                                @endphp

                                <div class="min-w-48">
                                <x-keys::select
                                    name="sortBy"
                                    wire:model.live="sortBy"
                                    size="sm"
                                    value="{{ $currentSortValue }}"
                                >
                                    <x-keys::select.option value="created_at" :label="__('Newest First')" />
                                    <x-keys::select.option value="price_asc" :label="__('Price: Low to High')" />
                                    <x-keys::select.option value="price_desc" :label="__('Price: High to Low')" />
                                    <x-keys::select.option value="featured" :label="__('Featured First')" />
                                </x-keys::select>
                                </div>
                            </div>
                        </div>

                        <!-- Active Filters -->
                        @if($search || $selectedMake || $selectedModel || $minPrice || $maxPrice || $selectedYear || $selectedFuelType || $selectedTransmission || $minMileage || $maxMileage || $featuredOnly)
                            <div class="mt-4 pt-4 border-t border-neutral-200">
                                <div class="flex flex-wrap gap-2">
                                    <span class="text-sm text-neutral-600">{{ __('Active filters:') }}</span>

                                    @if($search)
                                        <x-keys::badge variant="outline" color="neutral" size="sm">
                                            {{ __('Search: :term', ['term' => $search]) }}
                                            <x-keys::icon name="heroicon-o-x-mark" size="xs" class="ml-1 cursor-pointer" wire:click="$set('search', '')" />
                                        </x-keys::badge>
                                    @endif

                                    @if($featuredOnly)
                                        <x-keys::badge variant="outline" color="brand" size="sm">
                                            {{ __('Featured Only') }}
                                            <x-keys::icon name="heroicon-o-x-mark" size="xs" class="ml-1 cursor-pointer" wire:click="$set('featuredOnly', false)" />
                                        </x-keys::badge>
                                    @endif

                                    @if($selectedMake)
                                        <x-keys::badge variant="outline" color="neutral" size="sm">
                                            {{ $makes->firstWhere('id', $selectedMake)?->name }}
                                            <x-keys::icon name="heroicon-o-x-mark" size="xs" class="ml-1 cursor-pointer" wire:click="$set('selectedMake', '')" />
                                        </x-keys::badge>
                                    @endif

                                    @if($selectedModel)
                                        <x-keys::badge variant="outline" color="neutral" size="sm">
                                            {{ $models->firstWhere('id', $selectedModel)?->name }}
                                            <x-keys::icon name="heroicon-o-x-mark" size="xs" class="ml-1 cursor-pointer" wire:click="$set('selectedModel', '')" />
                                        </x-keys::badge>
                                    @endif

                                    @if($selectedFuelType)
                                        @php
                                            $fuelBadgeColor = match(strtolower($selectedFuelType)) {
                                                'electric' => 'success',
                                                'hybrid', 'plug-in hybrid' => 'info',
                                                'diesel' => 'neutral',
                                                'gasoline' => 'warning',
                                                default => 'neutral'
                                            };
                                        @endphp
                                        <x-keys::badge variant="solid" :color="$fuelBadgeColor" size="sm">
                                            {{ $selectedFuelType }}
                                            <x-keys::icon name="heroicon-o-x-mark" size="xs" class="ml-1 cursor-pointer" wire:click="$set('selectedFuelType', '')" />
                                        </x-keys::badge>
                                    @endif

                                    @if($minPrice || $maxPrice)
                                        <x-keys::badge variant="outline" color="neutral" size="sm">
                                            {{ __('Price: €:min - €:max', ['min' => $minPrice ?: '0', 'max' => $maxPrice ?: '∞']) }}
                                            <x-keys::icon name="heroicon-o-x-mark" size="xs" class="ml-1 cursor-pointer" wire:click="$set('minPrice', ''); $set('maxPrice', '')" />
                                        </x-keys::badge>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Cars Grid -->
                    @if($cars->count() > 0)
                        <div class="grid grid-cols-[repeat(auto-fit,minmax(320px,1fr))] gap-4 mb-8">
                            @foreach($cars as $car)
                                <x-car-card :car="$car" />
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="flex justify-center">
                            {{ $cars->links() }}
                        </div>
                    @else
                        <!-- Empty State -->
                        <x-keys::card class="text-center py-16">
                            <x-keys::icon name="heroicon-o-magnifying-glass" size="xl" class="text-neutral-400 mx-auto mb-4" />
                            <h3 class="text-lg font-semibold text-neutral-900 mb-2">
                                {{ __('No cars found') }}
                            </h3>
                            <p class="text-neutral-600 mb-6">
                                {{ __('Try adjusting your filters or search terms to find more results.') }}
                            </p>
                            <x-keys::button
                                variant="brand"
                                wire:click="clearFilters"
                            >
                                {{ __('Clear All Filters') }}
                            </x-keys::button>
                        </x-keys::card>
                    @endif
                </div>
            </div>
        </div>

        <!-- Floating Filter Button (Mobile Only) -->
        <div class="lg:hidden fixed bottom-6 right-6 z-40">
            <x-keys::button
                variant="brand"
                size="lg"
                wire:click="toggleMobileFilters"
                class="rounded-full shadow-lg relative"
            >
                <x-keys::icon name="heroicon-o-funnel" size="md" />
                @if($this->activeFiltersCount > 0)
                    <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-6 w-6 flex items-center justify-center font-medium">
                        {{ $this->activeFiltersCount }}
                    </span>
                @endif
            </x-keys::button>
        </div>

        <!-- Mobile Filter Panel -->
        <div class="lg:hidden">
            <!-- Backdrop -->
            <div
                x-show="$wire.showMobileFilters"
                x-transition:enter="transition-opacity ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                wire:click="toggleMobileFilters"
                class="fixed inset-0 bg-black bg-opacity-50 z-40"
                style="display: none;"
            ></div>

            <!-- Filter Panel -->
            <div
                x-show="$wire.showMobileFilters"
                x-transition:enter="transition-transform ease-out duration-300"
                x-transition:enter-start="translate-x-full"
                x-transition:enter-end="translate-x-0"
                x-transition:leave="transition-transform ease-in duration-200"
                x-transition:leave-start="translate-x-0"
                x-transition:leave-end="translate-x-full"
                class="fixed top-0 right-0 h-full w-full max-w-sm bg-white shadow-xl z-50 overflow-y-auto"
                style="display: none;"
            >
                <div class="p-6">
                    <!-- Header -->
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-lg font-semibold text-neutral-900">{{ __('Filter Cars') }}</h2>
                        <div class="flex items-center space-x-2">
                            @if($search || $selectedMake || $selectedModel || $minPrice || $maxPrice || $selectedYear || $selectedFuelType || $selectedTransmission || $minMileage || $maxMileage || $featuredOnly)
                                <x-keys::button
                                    variant="ghost"
                                    size="sm"
                                    wire:click="clearFilters"
                                    class="text-brand-600 hover:text-brand-700"
                                >
                                    {{ __('Clear All') }}
                                </x-keys::button>
                            @endif
                            <x-keys::button
                                variant="ghost"
                                size="sm"
                                wire:click="toggleMobileFilters"
                                class="p-2"
                            >
                                <x-keys::icon name="heroicon-o-x-mark" size="md" />
                            </x-keys::button>
                        </div>
                    </div>

                    <!-- Filters -->
                    <div class="space-y-6">
                        <!-- Search -->
                        <div>
                            <x-keys::input
                                name="search"
                                wire:model.live.debounce.300ms="search"
                                :label="__('Search')"
                                :placeholder="__('Search by make, model or description...')"
                                icon-left="heroicon-o-magnifying-glass"
                                clearable
                                size="md"
                            />
                        </div>

                        <!-- Featured Only -->
                        <div>
                            <x-keys::checkbox
                                name="featuredOnly"
                                wire:model.live="featuredOnly"
                                :label="__('Featured Cars Only')"
                                size="md"
                            />
                        </div>

                        <!-- Make Filter -->
                        <div>
                            <x-keys::select
                                name="selectedMake"
                                wire:model.live="selectedMake"
                                :label="__('Make')"
                                :placeholder="__('All Makes')"
                                size="md"
                                clearable
                            >
                                @foreach($makes as $make)
                                    <x-keys::select.option
                                        :value="$make->id"
                                        :label="$make->name . ' (' . $make->cars_count . ')'"
                                    />
                                @endforeach
                            </x-keys::select>
                        </div>

                        <!-- Model Filter -->
                        @if($selectedMake && $models->count() > 0)
                            <div>
                                <x-keys::select
                                    name="selectedModel"
                                    wire:model.live="selectedModel"
                                    :label="__('Model')"
                                    :placeholder="__('All Models')"
                                    size="md"
                                    clearable
                                >
                                    @foreach($models as $model)
                                        <x-keys::select.option
                                            :value="$model->id"
                                            :label="$model->name . ' (' . $model->cars_count . ')'"
                                        />
                                    @endforeach
                                </x-keys::select>
                            </div>
                        @endif

                        <!-- Price Range -->
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 mb-3">{{ __('Price Range') }}</label>
                            <div class="grid grid-cols-2 gap-3">
                                <x-keys::input
                                    name="minPrice"
                                    type="number"
                                    wire:model.live.debounce.500ms="minPrice"
                                    :placeholder="__('Min Price')"
                                    size="md"
                                />
                                <x-keys::input
                                    name="maxPrice"
                                    type="number"
                                    wire:model.live.debounce.500ms="maxPrice"
                                    :placeholder="__('Max Price')"
                                    size="md"
                                />
                            </div>
                        </div>

                        <!-- Year Filter -->
                        @if($years->count() > 0)
                            <div>
                                <x-keys::select
                                    name="selectedYear"
                                    wire:model.live="selectedYear"
                                    :label="__('Year')"
                                    :placeholder="__('Any Year')"
                                    size="md"
                                    clearable
                                >
                                    @foreach($years->reverse() as $year)
                                        <x-keys::select.option :value="$year" :label="$year" />
                                    @endforeach
                                </x-keys::select>
                            </div>
                        @endif

                        <!-- Fuel Type Filter -->
                        @if($fuelTypes->count() > 0)
                            <div>
                                <x-keys::select
                                    name="selectedFuelType"
                                    wire:model.live="selectedFuelType"
                                    :label="__('Fuel Type')"
                                    :placeholder="__('Any Fuel Type')"
                                    size="md"
                                    clearable
                                >
                                    @foreach($fuelTypes as $fuelType)
                                        <x-keys::select.option :value="$fuelType" :label="$fuelType" />
                                    @endforeach
                                </x-keys::select>
                            </div>
                        @endif

                        <!-- Transmission Filter -->
                        @if($transmissions->count() > 0)
                            <div>
                                <x-keys::select
                                    name="selectedTransmission"
                                    wire:model.live="selectedTransmission"
                                    :label="__('Transmission')"
                                    :placeholder="__('Any Transmission')"
                                    size="md"
                                    clearable
                                >
                                    @foreach($transmissions as $transmission)
                                        <x-keys::select.option :value="$transmission" :label="$transmission" />
                                    @endforeach
                                </x-keys::select>
                            </div>
                        @endif

                        <!-- Mileage Range -->
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 mb-3">{{ __('Mileage Range (km)') }}</label>
                            <div class="grid grid-cols-2 gap-3">
                                <x-keys::input
                                    name="minMileage"
                                    type="number"
                                    wire:model.live.debounce.500ms="minMileage"
                                    :placeholder="__('Min Mileage')"
                                    size="md"
                                />
                                <x-keys::input
                                    name="maxMileage"
                                    type="number"
                                    wire:model.live.debounce.500ms="maxMileage"
                                    :placeholder="__('Max Mileage')"
                                    size="md"
                                />
                            </div>
                        </div>
                    </div>

                    <!-- Apply Button -->
                    <div class="mt-8">
                        <x-keys::button
                            variant="brand"
                            size="md"
                            wire:click="toggleMobileFilters"
                            class="w-full"
                        >
                            {{ __('Apply Filters') }}
                        </x-keys::button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
