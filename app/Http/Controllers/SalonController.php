<?php

namespace App\Http\Controllers;

use App\Models\Salon;

class SalonController extends Controller
{
    public function show(Salon $salon)
    {
        abort_if(!$salon->is_active, 404);


        $salon->load([
            'services',
            'workingHours',
        ]);


        return view('salon.show', [
            'salon' => $salon,
        ]);
    }
}
