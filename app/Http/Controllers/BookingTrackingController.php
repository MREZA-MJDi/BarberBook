<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookingTrackingController extends Controller
{
    /**
     * نمایش فرم پیگیری نوبت.
     */
    public function create(Request $request): View
    {
        return view('booking.tracking', [
            'referenceCode' => $request->query('reference'),
        ]);
    }

    /**
     * جستجوی نوبت با کد رهگیری و شماره موبایل.
     */
    public function lookup(Request $request): View
    {
        $validated = $request->validate([
            'reference_code' => [
                'required',
                'string',
                'max:100',
            ],

            'customer_phone' => [
                'required',
                'string',
                'max:30',
            ],
        ], [
            'reference_code.required' => 'کد رهگیری را وارد کنید.',
            'reference_code.max' => 'کد رهگیری نامعتبر است.',

            'customer_phone.required' => 'شماره موبایل را وارد کنید.',
            'customer_phone.max' => 'شماره موبایل نامعتبر است.',
        ]);


        $referenceCode = $this->normalizeReference(
            $validated['reference_code']
        );

        $phoneCandidates = $this->phoneCandidates(
            $validated['customer_phone']
        );


        $booking = Booking::query()
            ->with([
                'salon',
                'service',
            ])
            ->where('reference_code', $referenceCode)
            ->whereIn('customer_phone', $phoneCandidates)
            ->first();


        /*
        |--------------------------------------------------------------------------
        | Security
        |--------------------------------------------------------------------------
        |
        | عمداً پیام جداگانه برای «کد درست / موبایل غلط» نداریم.
        | اینطوری اطلاعات Booking به شخص دیگر لو نمی‌رود.
        |
        */

        if (!$booking) {

            return back()
                ->withInput()
                ->withErrors([
                    'tracking' => 'نوبتی با این کد رهگیری و شماره موبایل پیدا نشد.',
                ]);

        }


        return view('booking.tracking', [
            'booking' => $booking,
            'referenceCode' => $booking->reference_code,
        ]);
    }


    /**
     * Normalize reference code.
     */
    private function normalizeReference(string $reference): string
    {
        return strtoupper(
            preg_replace(
                '/\s+/',
                '',
                trim($reference)
            )
        );
    }


    /**
     * Generate possible Iranian phone representations.
     */
    private function phoneCandidates(string $phone): array
    {
        $phone = trim($phone);

        /*
        |--------------------------------------------------------------------------
        | Persian / Arabic digits → English
        |--------------------------------------------------------------------------
        */

        $phone = strtr($phone, [
            '۰' => '0',
            '۱' => '1',
            '۲' => '2',
            '۳' => '3',
            '۴' => '4',
            '۵' => '5',
            '۶' => '6',
            '۷' => '7',
            '۸' => '8',
            '۹' => '9',

            '٠' => '0',
            '١' => '1',
            '٢' => '2',
            '٣' => '3',
            '٤' => '4',
            '٥' => '5',
            '٦' => '6',
            '٧' => '7',
            '٨' => '8',
            '٩' => '9',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Remove separators
        |--------------------------------------------------------------------------
        */

        $phone = preg_replace('/[\s\-\(\)]/', '', $phone);


        $candidates = [
            $phone,
        ];


        /*
        |--------------------------------------------------------------------------
        | +98xxxxxxxxxx
        |--------------------------------------------------------------------------
        */

        if (str_starts_with($phone, '+98')) {

            $local = '0' . substr($phone, 3);

            $candidates[] = $local;

        }


        /*
        |--------------------------------------------------------------------------
        | 0098xxxxxxxxxx
        |--------------------------------------------------------------------------
        */

        if (str_starts_with($phone, '0098')) {

            $local = '0' . substr($phone, 4);

            $candidates[] = $local;

        }


        /*
        |--------------------------------------------------------------------------
        | 98xxxxxxxxxx
        |--------------------------------------------------------------------------
        */

        if (str_starts_with($phone, '98') && !str_starts_with($phone, '980')) {

            $local = '0' . substr($phone, 2);

            $candidates[] = $local;

        }


        /*
        |--------------------------------------------------------------------------
        | Normalize local → international
        |--------------------------------------------------------------------------
        */

        if (str_starts_with($phone, '09')) {

            $candidates[] = '98' . substr($phone, 1);
            $candidates[] = '+98' . substr($phone, 1);

        }


        return array_values(
            array_unique(
                array_filter($candidates)
            )
        );
    }
}
