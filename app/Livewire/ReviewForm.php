<?php

namespace App\Livewire;

use App\Enums\ReviewStatus;
use App\Models\Review;
use Livewire\Attributes\On;
use Livewire\Component;

class ReviewForm extends Component
{
    public string $customer_name = '';
    public string $customer_location = '';
    public int $rating = 5;
    public string $content = '';
    public bool $showSuccess = false;
    public bool $showModal = false;

    protected array $rules = [
        'customer_name' => 'required|string|max:255',
        'customer_location' => 'nullable|string|max:255',
        'rating' => 'required|integer|min:1|max:5',
        'content' => 'required|string|min:10|max:1000',
    ];

    protected array $messages = [
        'customer_name.required' => 'Please enter your name.',
        'customer_name.max' => 'Name must not exceed 255 characters.',
        'rating.required' => 'Please select a rating.',
        'rating.min' => 'Rating must be at least 1 star.',
        'rating.max' => 'Rating cannot exceed 5 stars.',
        'content.required' => 'Please share your experience.',
        'content.min' => 'Review must be at least 10 characters.',
        'content.max' => 'Review must not exceed 1000 characters.',
    ];

    protected function getMessages(): array
    {
        return [
            'customer_name.required' => __('Please enter your name.'),
            'customer_name.max' => __('Name must not exceed 255 characters.'),
            'rating.required' => __('Please select a rating.'),
            'rating.min' => __('Rating must be at least 1 star.'),
            'rating.max' => __('Rating cannot exceed 5 stars.'),
            'content.required' => __('Please share your experience.'),
            'content.min' => __('Review must be at least 10 characters.'),
            'content.max' => __('Review must not exceed 1000 characters.'),
        ];
    }

    #[On('openReviewModal')]
    public function openModal()
    {
        $this->showModal = true;
        $this->showSuccess = false;
        $this->resetForm();
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->showSuccess = false;
        $this->resetForm();
    }

    public function submitReview()
    {
        $this->validate();

        Review::create([
            'customer_name' => $this->customer_name,
            'customer_location' => $this->customer_location ?: null,
            'rating' => $this->rating,
            'content' => $this->content,
            'status' => ReviewStatus::Pending,
        ]);

        // Show success message
        $this->showSuccess = true;

        // Auto close modal after 3 seconds
        $this->js('setTimeout(() => { $wire.closeModal() }, 3000)');
    }

    private function resetForm()
    {
        $this->reset(['customer_name', 'customer_location', 'content']);
        $this->rating = 5;
        $this->resetErrorBag();
    }

    public function getCharacterCountProperty()
    {
        return 1000 - strlen($this->content);
    }

    public function render()
    {
        return view('livewire.review-form');
    }
}