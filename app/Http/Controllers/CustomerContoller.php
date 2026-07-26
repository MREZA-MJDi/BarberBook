<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerContoller extends Controller
{
    public function landing()
    {
        $shop = (object)[
            'id' => 1,
            'name' => 'آرایشگاه VIP',
            'cover' => '/images/service1',
            'rating' => 4.8,
            'today_hours' => '10:00 تا 20:00',
        ];

        return view('customer.landing', compact('shop'));
    }

    public function services()
    {
        $shop = (object)['id' => 1];

        $services = [
            (object)['id' => 1, 'name' => 'اصلاح مردانه', 'duration' => 20, 'price' => 80000],
            (object)['id' => 2, 'name' => 'اصلاح + خط', 'duration' => 30, 'price' => 120000],
            (object)['id' => 3, 'name' => 'اصلاح کودک', 'duration' => 15, 'price' => 60000],
        ];

        return view('customer.services', compact('shop', 'services'));
    }

    public function barbers($shopId, $serviceId)
    {
        $shop = (object)['id' => $shopId];
        $service = (object)['id' => $serviceId];

        $barbers = [
            (object)[
                'id' => 1,
                'name' => 'علی رضایی',
                'skill' => 'اصلاح تخصصی',
                'avatar' => '/images/avatar1.jpg',
                'is_online' => true
            ],
            (object)[
                'id' => 2,
                'name' => 'مهدی کریمی',
                'skill' => 'اصلاح و گریم',
                'avatar' => '/images/avatar2.jpg',
                'is_online' => false
            ],
        ];

        return view('customer.barbers', compact('shop', 'service', 'barbers'));
    }

    public function calendar($shopId, $serviceId, $barberId)
    {
        $shop = (object)['id' => $shopId];
        $service = (object)['id' => $serviceId];
        $barber = (object)['id' => $barberId];

        $days = [];

        for ($i = 0; $i < 30; $i++) {
            $date = now()->addDays($i);

            $days[] = (object)[
                'day' => $date->day,
                'date' => $date->toDateString(),
                'available' => rand(0, 1) === 1
            ];
        }

        return view('customer.calendar', [
            'shop' => $shop,
            'service' => $service,
            'barber' => $barber,
            'days' => $days,
            'monthName' => now()->monthName,
            'year' => now()->year,
        ]);
    }

    public function times()
    {
        $times = [
            (object)['label' => '10:00', 'value' => '10:00', 'free' => true],
            (object)['label' => '10:30', 'value' => '10:30', 'free' => false],
            (object)['label' => '11:00', 'value' => '11:00', 'free' => true],
            (object)['label' => '11:30', 'value' => '11:30', 'free' => true],
            (object)['label' => '12:00', 'value' => '12:00', 'free' => false],
            (object)['label' => '12:30', 'value' => '12:30', 'free' => true],
        ];

        return view('customer.times', [
            'times' => $times,
            'shopId' => 1,
            'serviceId' => 2,
            'barberId' => 3,
            'selectedDate' => '2026-07-26'
        ]);
    }

    public function review()
    {
        return view('customer.review', [
            'shopName' => 'آرایشگاه VIP',
            'barberName' => 'علی رضایی',
            'serviceName' => 'اصلاح مردانه',
            'date' => '2026-07-26',
            'time' => '10:30',
            'price' => 80000,
        ]);
    }

    public function success()
    {
        return view('customer.success', [
            'shopName' => 'آرایشگاه VIP',
            'barberName' => 'علی رضایی',
            'serviceName' => 'اصلاح مردانه',
            'date' => '2026-07-26',
            'time' => '10:30',
            'price' => 80000,
        ]);
    }
}
