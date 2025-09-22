@props([
    'name' => 'rating',
    'value' => 0,
    'required' => false,
    'label' => '',
    'class' => ''
])

<div class="space-y-3 {{ $class }}">
    @if($label)
        <label class="block text-lg font-medium text-neutral-700 font-helvetica">
            {{ $label }}
            @if($required)
                <span class="text-brand-500">*</span>
            @endif
        </label>
    @endif

    <div class="flex items-center space-x-1">
        <x-keys::range
            name="{{ $name }}"
            min="1"
            max="5"
            step="1"
            :value="$value"
            show-values
            size="lg"
            class="luxury-star-rating"
            :required="$required"
        />
    </div>

    <div class="flex items-center justify-between text-sm text-neutral-500 font-helvetica font-light">
        <span>Poor</span>
        <span>Excellent</span>
    </div>
</div>

<style>
/* Custom styling for luxury star rating */
.luxury-star-rating {
    --range-track-bg: #f3f4f6;
    --range-fill-bg: linear-gradient(90deg, #d97706, #f59e0b);
    --range-thumb-bg: #f59e0b;
    --range-thumb-border: #d97706;
    --range-thumb-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
}

.luxury-star-rating input[type="range"] {
    background: transparent;
    cursor: pointer;
}

.luxury-star-rating input[type="range"]::-webkit-slider-track {
    background: var(--range-track-bg);
    height: 8px;
    border-radius: 4px;
    border: none;
}

.luxury-star-rating input[type="range"]::-webkit-slider-thumb {
    appearance: none;
    height: 24px;
    width: 24px;
    border-radius: 50%;
    background: var(--range-thumb-bg);
    border: 2px solid var(--range-thumb-border);
    box-shadow: var(--range-thumb-shadow);
    cursor: pointer;
    transition: all 0.2s ease;
}

.luxury-star-rating input[type="range"]::-webkit-slider-thumb:hover {
    transform: scale(1.1);
    box-shadow: 0 6px 16px rgba(245, 158, 11, 0.4);
}

.luxury-star-rating input[type="range"]::-moz-range-track {
    background: var(--range-track-bg);
    height: 8px;
    border-radius: 4px;
    border: none;
}

.luxury-star-rating input[type="range"]::-moz-range-thumb {
    height: 24px;
    width: 24px;
    border-radius: 50%;
    background: var(--range-thumb-bg);
    border: 2px solid var(--range-thumb-border);
    box-shadow: var(--range-thumb-shadow);
    cursor: pointer;
    transition: all 0.2s ease;
}
</style>