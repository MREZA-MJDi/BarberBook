<?php

namespace App\Services;

use App\Models\Booking;
use Illuminate\Support\Facades\Log;

class SmsService
{
    /**
     * Send notifications after a new booking is created.
     *
     * Customer:
     * - booking reference code
     * - pending status
     *
     * Salon owner:
     * - new booking details
     */
    public function sendBookingCreated(Booking $booking): void
    {
        $booking->loadMissing([
            'salon.user',
            'service',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Customer SMS
        |--------------------------------------------------------------------------
        */

        if (!blank($booking->customer_phone)) {

            $this->send(
                $booking->customer_phone,
                $this->customerBookingCreatedMessage($booking)
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Salon Owner SMS
        |--------------------------------------------------------------------------
        */

        $barberPhone = $booking->salon?->user?->phone;

        if (!blank($barberPhone)) {

            $this->send(
                $barberPhone,
                $this->barberBookingCreatedMessage($booking)
            );

        }
    }


    /**
     * Send approval notification to customer.
     */
    public function sendBookingApproved(Booking $booking): void
    {
        $booking->loadMissing([
            'salon',
            'service',
        ]);

        if (blank($booking->customer_phone)) {
            return;
        }

        $this->send(
            $booking->customer_phone,
            $this->customerBookingApprovedMessage($booking)
        );
    }


    /**
     * Send rejection notification to customer.
     */
    public function sendBookingRejected(Booking $booking): void
    {
        $booking->loadMissing([
            'salon',
            'service',
        ]);

        if (blank($booking->customer_phone)) {
            return;
        }

        $this->send(
            $booking->customer_phone,
            $this->customerBookingRejectedMessage($booking)
        );
    }


    /**
     * Send reschedule notification to customer.
     */
    public function sendBookingRescheduled(Booking $booking): void
    {
        $booking->loadMissing([
            'salon',
            'service',
        ]);

        if (blank($booking->customer_phone)) {
            return;
        }

        $this->send(
            $booking->customer_phone,
            $this->customerBookingRescheduledMessage($booking)
        );
    }


    /**
     * Low-level provider layer.
     *
     * Kavenegar will be connected here later.
     */
    protected function send(
        string $phone,
        string $message
    ): void {
        $phone = trim($phone);
        $message = trim($message);

        if ($phone === '' || $message === '') {
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Temporary development mode
        |--------------------------------------------------------------------------
        |
        | فعلاً SMS واقعی ارسال نمی‌کنیم.
        | بعد از اتصال Kavenegar فقط همین لایه تغییر می‌کند.
        |
        */

        Log::info('SMS prepared.', [
            'phone' => $phone,
            'message' => $message,
        ]);
    }


    /**
     * Customer: booking created / pending.
     */
    protected function customerBookingCreatedMessage(
        Booking $booking
    ): string {
        return $this->cleanMessage(
            sprintf(
                "BarberBook\nرزرو شما در %s با موفقیت ثبت شد.\nکد رهگیری: %s\nوضعیت: در انتظار تأیید آرایشگر.\nبرای پیگیری نوبت، کد رهگیری و شماره موبایل خود را در بخش پیگیری نوبت وارد کنید.",
                $booking->salon?->name ?? 'آرایشگاه',
                $booking->reference_code
            )
        );
    }


    /**
     * Salon owner: new booking.
     */
    protected function barberBookingCreatedMessage(
        Booking $booking
    ): string {
        return $this->cleanMessage(
            sprintf(
                "BarberBook\nرزرو جدید ثبت شد.\nمشتری: %s\nخدمت: %s\nتاریخ: %s\nساعت: %s\nکد رهگیری: %s\nبرای بررسی و تأیید، وارد پنل مدیریت شوید.",
                $booking->customer_name ?? 'مشتری',
                $booking->service?->name ?? 'خدمت',
                $this->formatDate($booking->booking_date),
                $this->formatTime($booking->booking_time),
                $booking->reference_code
            )
        );
    }


    /**
     * Customer: booking approved.
     */
    protected function customerBookingApprovedMessage(
        Booking $booking
    ): string {
        return $this->cleanMessage(
            sprintf(
                "BarberBook\nنوبت شما در %s تأیید شد.\nخدمت: %s\nتاریخ: %s\nساعت: %s\nکد رهگیری: %s\nبرای مشاهده وضعیت نوبت، از بخش پیگیری نوبت استفاده کنید.",
                $booking->salon?->name ?? 'آرایشگاه',
                $booking->service?->name ?? 'خدمت',
                $this->formatDate($booking->booking_date),
                $this->formatTime($booking->booking_time),
                $booking->reference_code
            )
        );
    }


    /**
     * Customer: booking rejected.
     */
    protected function customerBookingRejectedMessage(
        Booking $booking
    ): string {
        return $this->cleanMessage(
            sprintf(
                "BarberBook\nمتأسفانه نوبت شما در %s تأیید نشد.\nکد رهگیری: %s\nبرای اطلاعات بیشتر با آرایشگاه تماس بگیرید.",
                $booking->salon?->name ?? 'آرایشگاه',
                $booking->reference_code
            )
        );
    }


    /**
     * Customer: booking rescheduled.
     */
    protected function customerBookingRescheduledMessage(
        Booking $booking
    ): string {
        return $this->cleanMessage(
            sprintf(
                "BarberBook\nزمان نوبت شما در %s تغییر کرد.\nخدمت: %s\nتاریخ جدید: %s\nساعت جدید: %s\nکد رهگیری: %s\nبرای پیگیری نوبت از بخش پیگیری نوبت استفاده کنید.",
                $booking->salon?->name ?? 'آرایشگاه',
                $booking->service?->name ?? 'خدمت',
                $this->formatDate($booking->booking_date),
                $this->formatTime($booking->booking_time),
                $booking->reference_code
            )
        );
    }


    /**
     * Format booking date.
     */
    protected function formatDate(mixed $date): string
    {
        if (!$date) {
            return '—';
        }

        try {

            return \Carbon\Carbon::parse($date)
                ->locale('fa')
                ->translatedFormat('j F Y');

        } catch (\Throwable) {

            return (string) $date;
        }
    }


    /**
     * Format booking time.
     */
    protected function formatTime(mixed $time): string
    {
        if (!$time) {
            return '—';
        }

        return substr((string) $time, 0, 5);
    }


    /**
     * Normalize message whitespace.
     */
    protected function cleanMessage(string $message): string
    {
        return trim(
            preg_replace(
                "/\r\n|\r|\n{3,}/",
                "\n",
                $message
            )
        );
    }
}
