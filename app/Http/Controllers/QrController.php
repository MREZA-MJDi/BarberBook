<?php

namespace App\Http\Controllers;

use App\Models\Salon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use chillerlan\QRCode\Output\QRMarkupSVG;

class QrController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Index
    |--------------------------------------------------------------------------
    */

    /**
     * Display salon QR Code page.
     */
    public function index(): \Illuminate\Contracts\View\View
    {
        $salon = Auth::user()?->salon;

        abort_if(!$salon, 404);

        return view(
            'dashboard.qr.index',
            compact('salon')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Generate
    |--------------------------------------------------------------------------
    */

    /**
     * Generate salon QR Code.
     *
     * The token can only be generated once.
     */
    public function generate(): RedirectResponse
    {
        $salon = Auth::user()?->salon;

        abort_if(!$salon, 404);

        /*
        |--------------------------------------------------------------------------
        | Already Generated
        |--------------------------------------------------------------------------
        */

        if (filled($salon->qr_token)) {
            return redirect()
                ->route('qr.index')
                ->with(
                    'info',
                    'QR Code سالن شما قبلاً ساخته شده است.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Generate Unique Token
        |--------------------------------------------------------------------------
        */

        do {
            $token = 'BB-' . strtoupper(Str::random(16));
        } while (
            Salon::query()
                ->where('qr_token', $token)
                ->exists()
        );

        /*
        |--------------------------------------------------------------------------
        | Save
        |--------------------------------------------------------------------------
        */

        $salon->update([
            'qr_token' => $token,
        ]);

        return redirect()
            ->route('qr.index')
            ->with(
                'success',
                'QR Code سالن شما با موفقیت ساخته شد.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Public URL
    |--------------------------------------------------------------------------
    */

    /**
     * Get public salon URL.
     */
    private function publicUrl(Salon $salon): string
    {
        return route(
            'salon.public',
            [
                'qr_token' => $salon->qr_token,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | QR Options
    |--------------------------------------------------------------------------
    */

    /**
     * Build QR options for SVG output.
     */
    private function qrOptions(int $scale): QROptions
    {
        return new QROptions([
            'outputInterface' => QRMarkupSVG::class,
            'eccLevel' => 'H',
            'addQuietzone' => true,
            'scale' => $scale,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Image
    |--------------------------------------------------------------------------
    */

    /**
     * Render salon QR Code as SVG.
     */
    public function image(): Response
    {
        $salon = Auth::user()?->salon;

        abort_if(!$salon, 404);

        abort_if(
            blank($salon->qr_token),
            404
        );

        $url = $this->publicUrl($salon);

        $svg = (new QRCode(
            $this->qrOptions(8)
        ))->render($url);

        return response(
            $svg,
            200,
            [
                'Content-Type' => 'image/svg+xml',
                'Cache-Control' => 'private, max-age=3600',
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Download
    |--------------------------------------------------------------------------
    */

    /**
     * Download salon QR Code.
     */
    public function download(): Response
    {
        $salon = Auth::user()?->salon;

        abort_if(!$salon, 404);

        abort_if(
            blank($salon->qr_token),
            404
        );

        $url = $this->publicUrl($salon);

        $svg = (new QRCode(
            $this->qrOptions(12)
        ))->render($url);

        $filename =
            Str::slug(
                $salon->name ?: 'salon'
            ) . '-qr.svg';

        return response(
            $svg,
            200,
            [
                'Content-Type' =>
                    'image/svg+xml',

                'Content-Disposition' =>
                    'attachment; filename="' . $filename . '"',

                'Cache-Control' =>
                    'no-cache, no-store, must-revalidate',
            ]
        );
    }
}
