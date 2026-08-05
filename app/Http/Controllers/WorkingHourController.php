<?php

namespace App\Http\Controllers;

use App\Http\Requests\WorkingHourRequest;
use App\Models\WorkingHour;
use App\Support\Days;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;


class WorkingHourController extends Controller
{


    /**
     * Display working hours.
     */
    public function index(): View
    {

        $salon = auth()->user()->salon;


        $workingHours = WorkingHour::where('salon_id', $salon->id)
            ->orderBy('day_of_week')
            ->get();



        return view(
            'dashboard.working-hours.index',
            [
                'workingHours' => $workingHours,
                'days' => Days::all(),
            ]
        );

    }







    /**
     * Show create form.
     */
    public function create(): View
    {


        return view(
            'dashboard.working-hours.create',
            [
                'days' => Days::all(),
            ]
        );


    }









    /**
     * Store working hour.
     */
    public function store(
        WorkingHourRequest $request
    ): RedirectResponse {


        $salon = auth()->user()->salon;



        WorkingHour::create([


            'salon_id' => $salon->id,


            'day_of_week' => $request->day_of_week,


            'start_time' => $request->start_time,


            'end_time' => $request->end_time,


            'break_start' => $request->break_start,


            'break_end' => $request->break_end,


            'is_closed' => $request->boolean('is_closed'),


        ]);





        return redirect()
            ->route('working-hours.index')
            ->with(
                'success',
                'ساعت کاری با موفقیت اضافه شد.'
            );


    }









    /**
     * Show edit form.
     */
    public function edit(
        WorkingHour $workingHour
    ): View {


        $this->checkOwner($workingHour);



        return view(
            'dashboard.working-hours.edit',
            [
                'workingHour' => $workingHour,
                'days' => Days::all(),
            ]
        );


    }









    /**
     * Update working hour.
     */
    public function update(
        WorkingHourRequest $request,
        WorkingHour $workingHour
    ): RedirectResponse {


        $this->checkOwner($workingHour);




        $workingHour->update([


            'day_of_week' => $request->day_of_week,


            'start_time' => $request->start_time,


            'end_time' => $request->end_time,


            'break_start' => $request->break_start,


            'break_end' => $request->break_end,


            'is_closed' => $request->boolean('is_closed'),


        ]);






        return redirect()
            ->route('working-hours.index')
            ->with(
                'success',
                'ساعت کاری بروزرسانی شد.'
            );


    }









    /**
     * Delete working hour.
     */
    public function destroy(
        WorkingHour $workingHour
    ): RedirectResponse {


        $this->checkOwner($workingHour);



        $workingHour->delete();





        return redirect()
            ->route('working-hours.index')
            ->with(
                'success',
                'ساعت کاری حذف شد.'
            );


    }









    /**
     * Check ownership.
     */
    private function checkOwner(
        WorkingHour $workingHour
    ): void {


        abort_if(

            $workingHour->salon_id !== auth()->user()->salon->id,

            403

        );


    }



}
