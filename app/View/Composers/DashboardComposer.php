<?php

namespace App\View\Composers;

use App\Models\Booking;
use Illuminate\View\View;

class DashboardComposer
{
    public function compose(View $view): void
    {
        $user = auth()->user();

        if (!$user || !$user->salon) {
            $view->with([
                'topbarNotifications' => collect(),
                'topbarNotificationsCount' => 0,
            ]);

            return;
        }

        $salonId = $user->salon->id;

        $notifications = Booking::where('salon_id', $salonId)
            ->where('status', 'pending')
            ->with('service')
            ->latest('created_at')
            ->take(5)
            ->get();

        $notificationsCount = Booking::where('salon_id', $salonId)
            ->where('status', 'pending')
            ->count();

        $view->with([
            'topbarNotifications' => $notifications,
            'topbarNotificationsCount' => $notificationsCount,
        ]);
    }
}
