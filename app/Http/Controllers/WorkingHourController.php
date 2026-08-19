<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateWorkingHoursRequest;
use App\Models\WorkingHour;
use App\Support\Days;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class WorkingHourController extends Controller
{
    /**
     * Display weekly working hours.
     */
    public function index(): View
    {
        $salon = auth()->user()->salon;

        abort_unless($salon, 403);

        $workingHours = WorkingHour::query()
            ->where('salon_id', $salon->id)
            ->orderBy('day_of_week')
            ->get()
            ->keyBy('day_of_week');

        /*
        |--------------------------------------------------------------------------
        | Always provide all 7 days.
        |--------------------------------------------------------------------------
        */

        $week = [];

        foreach (range(0, 6) as $day) {
            $week[$day] = $workingHours->get($day);
        }

        return view(
            'dashboard.working-hours.index',
            [
                'week' => $week,
                'days' => Days::all(),
            ]
        );
    }

    /**
     * Update complete weekly schedule.
     */
    public function updateWeek(
        UpdateWorkingHoursRequest $request
    ): RedirectResponse {
        $salon = $request->user()->salon;

        abort_unless($salon, 403);

        $days = $request->validated('days');

        DB::transaction(function () use ($salon, $days): void {

            foreach (range(0, 6) as $day) {

                /*
                |--------------------------------------------------------------------------
                | Always have a data array for the day.
                |--------------------------------------------------------------------------
                */

                $data = $days[$day] ?? [];

                /*
                |--------------------------------------------------------------------------
                | Closed
                |--------------------------------------------------------------------------
                */

                $isClosed = filter_var(
                    $data['is_closed'] ?? false,
                    FILTER_VALIDATE_BOOLEAN
                );

                /*
                |--------------------------------------------------------------------------
                | Save
                |--------------------------------------------------------------------------
                |
                | WorkingHour is the recurring weekly template.
                |
                | 0 = Saturday
                | 1 = Sunday
                | 2 = Monday
                | ...
                | 6 = Friday
                |
                */

                WorkingHour::updateOrCreate(
                    [
                        'salon_id' => $salon->id,
                        'day_of_week' => $day,
                    ],
                    [
                        'start_time' => $isClosed
                            ? null
                            : ($data['start_time'] ?? null),

                        'end_time' => $isClosed
                            ? null
                            : ($data['end_time'] ?? null),

                        'break_start' => $isClosed
                            ? null
                            : ($data['break_start'] ?? null),

                        'break_end' => $isClosed
                            ? null
                            : ($data['break_end'] ?? null),

                        'is_closed' => $isClosed,
                    ]
                );
            }
        });

        return redirect()
            ->route('working-hours.index')
            ->with(
                'success',
                'برنامه ساعت کاری هفتگی با موفقیت ذخیره شد.'
            );
    }
}
