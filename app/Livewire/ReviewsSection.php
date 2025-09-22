<?php

namespace App\Livewire;

use App\Models\Review;
use Livewire\Component;

class ReviewsSection extends Component
{
    public function openReviewModal()
    {
        logger('ReviewsSection: openReviewModal called');
        $this->dispatch('openModal', ['id' => 'review-modal']);
        logger('ReviewsSection: openModal event dispatched with id: review-modal');
    }

    public function render()
    {
        $reviews = Review::approved()
            ->latest()
            ->limit(6)
            ->get();
        $averageRating = $reviews->avg('rating') ?? 0;
        $totalReviews = Review::approved()->count();

        return view('livewire.reviews-section', [
            'reviews' => $reviews,
            'averageRating' => $averageRating,
            'totalReviews' => $totalReviews,
        ]);
    }
}
