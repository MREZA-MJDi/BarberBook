<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use App\Models\Booking;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReviewController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Customer Reviews
    |--------------------------------------------------------------------------
    */

    /**
     * Store a new review.
     */
    public function store(StoreReviewRequest $request): RedirectResponse
    {
        $booking = Booking::query()
            ->with('review')
            ->findOrFail($request->integer('booking_id'));

        $this->authorize('create', $booking);

        if (
            $request->integer('salon_id')
            !== (int) $booking->salon_id
        ) {
            abort(403);
        }

        Review::create([
            'user_id' => $request->user()->id,
            'salon_id' => $booking->salon_id,
            'booking_id' => $booking->id,
            'rating' => $request->integer('rating'),
            'comment' => $request->input('comment'),
            'status' => 'pending',
        ]);

        return back()->with(
            'success',
            'نظر شما با موفقیت ثبت شد و پس از بررسی نمایش داده خواهد شد.'
        );
    }


    /**
     * Update customer's own review.
     */
    public function update(
        UpdateReviewRequest $request,
        Review $review
    ): RedirectResponse {
        $this->authorize('update', $review);

        $review->update([
            'rating' => $request->integer('rating'),
            'comment' => $request->input('comment'),
            'status' => 'pending',
        ]);

        return back()->with(
            'success',
            'نظر شما با موفقیت ویرایش شد و دوباره برای بررسی ارسال شد.'
        );
    }


    /**
     * Delete customer's own review.
     */
    public function destroy(
        Request $request,
        Review $review
    ): RedirectResponse {
        $this->authorize('delete', $review);

        $review->delete();

        return back()->with(
            'success',
            'نظر شما با موفقیت حذف شد.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Salon Owner Dashboard
    |--------------------------------------------------------------------------
    */

    /**
     * Display salon reviews.
     */
    public function index(Request $request): View
    {
        $this->authorize('viewAny', Review::class);

        $salon = $request->user()->salon;

        abort_unless($salon, 403);

        $reviews = Review::query()
            ->where('salon_id', $salon->id)
            ->with([
                'user',
                'booking.service',
            ])
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $publishedReviews = Review::query()
            ->where('salon_id', $salon->id)
            ->where('status', 'published');

        $averageRating = $publishedReviews->avg('rating');

        $ratingsCount = (clone $publishedReviews)->count();

        $ratingDistribution = [];

        for ($rating = 5; $rating >= 1; $rating--) {
            $ratingDistribution[$rating] = (clone $publishedReviews)
                ->where('rating', $rating)
                ->count();
        }

        return view('dashboard.reviews.index', [
            'reviews' => $reviews,
            'averageRating' => round($averageRating ?? 0, 1),
            'ratingsCount' => $ratingsCount,
            'ratingDistribution' => $ratingDistribution,
        ]);
    }


    /**
     * Publish a review.
     */
    public function publish(
        Request $request,
        Review $review
    ): RedirectResponse {
        $this->authorize('publish', $review);

        $review->update([
            'status' => 'published',
        ]);

        return back()->with(
            'success',
            'نظر با موفقیت منتشر شد.'
        );
    }


    /**
     * Reject / hide a review.
     */
    public function reject(
        Request $request,
        Review $review
    ): RedirectResponse {
        $this->authorize('reject', $review);

        $review->update([
            'status' => 'rejected',
        ]);

        return back()->with(
            'success',
            'نظر با موفقیت مخفی شد.'
        );
    }
}
