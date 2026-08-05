<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceRequest;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;


class ServiceController extends Controller
{


    /**
     * Display services list.
     */
    public function index(): View
    {

        $salon = auth()->user()->salon;



        $services = Service::where('salon_id', $salon->id)
            ->latest()
            ->paginate(10);



        return view(
            'dashboard.services.index',
            compact('services')
        );

    }







    /**
     * Show create form.
     */
    public function create(): View
    {

        return view(
            'dashboard.services.create'
        );

    }








    /**
     * Store service.
     */
    public function store(ServiceRequest $request): RedirectResponse {


        $salon = auth()->user()->salon;



        Service::create([


            'salon_id' => $salon->id,


            'name' => $request->name,


            'description' => $request->description,


            'duration' => $request->duration,


            'price' => $request->price,


            'is_active' => $request->boolean('is_active'),


        ]);





        return redirect()
            ->route('services.index')
            ->with(
                'success',
                'خدمت جدید با موفقیت اضافه شد.'
            );

    }









    /**
     * Show edit form.
     */
    public function edit(
        Service $service
    ): View {


        $this->checkOwner($service);



        return view(
            'dashboard.services.edit',
            compact('service')
        );

    }









    /**
     * Update service.
     */
    public function update(
        ServiceRequest $request,
        Service $service
    ): RedirectResponse {


        $this->checkOwner($service);




        $service->update([


            'name' => $request->name,


            'description' => $request->description,


            'duration' => $request->duration,


            'price' => $request->price,


            'is_active' => $request->boolean('is_active'),


        ]);





        return redirect()
            ->route('services.index')
            ->with(
                'success',
                'خدمت با موفقیت بروزرسانی شد.'
            );

    }









    /**
     * Delete service.
     */
    public function destroy(
        Service $service
    ): RedirectResponse {


        $this->checkOwner($service);



        $service->delete();





        return redirect()
            ->route('services.index')
            ->with(
                'success',
                'خدمت حذف شد.'
            );

    }









    /**
     * Check salon ownership.
     */
    private function checkOwner(
        Service $service
    ): void {


        abort_if(

            $service->salon_id !== auth()->user()->salon->id,

            403

        );

    }


}
