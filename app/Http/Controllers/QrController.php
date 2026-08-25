<?php

namespace App\Http\Controllers;

use App\Models\Salon;
use chillerlan\QRCode\Output\QRMarkupSVG;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class QrController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Index
    |--------------------------------------------------------------------------
    */

    public function index(): View
    {
        $salon = Auth::user()?->salon;

        abort_if(!$salon, 404);

        $qrSvg = null;

        /*
        |--------------------------------------------------------------------------
        | Generate SVG For Dashboard
        |--------------------------------------------------------------------------
        */

        if (filled($salon->qr_token)) {

            $url = $this->publicUrl($salon);

            $qrSvg = $this->renderQr(
                $url,
                8
            );
        }

        return view(
            'dashboard.qr.index',
            [
                'salon' => $salon,
                'qrSvg' => $qrSvg,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Generate
    |--------------------------------------------------------------------------
    */

    public function generate(): RedirectResponse
    {
        $salon = Auth::user()?->salon;

        abort_if(!$salon, 404);

        /*
        |--------------------------------------------------------------------------
        | Prevent Duplicate Generation
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

            $token = 'BB-' . strtoupper(
                    Str::random(16)
                );

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
    | Render QR
    |--------------------------------------------------------------------------
    */

    private function renderQr(
        string $url,
        int $scale = 8
    ): string {
        $options = new QROptions();

        $options->outputInterface = QRMarkupSVG::class;

        $options->outputBase64 = false;

        $options->eccLevel = 'H';

        $options->addQuietzone = true;

        $options->scale = max(
            1,
            $scale
        );

        $qrCode = new QRCode(
            $options
        );

        return $qrCode->render($url);
    }


    /*
    |--------------------------------------------------------------------------
    | Image
    |--------------------------------------------------------------------------
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

        $svg = $this->renderQr(
            $url,
            8
        );

        return response(
            $svg,
            200,
            [
                'Content-Type' =>
                    'image/svg+xml; charset=UTF-8',

                'Content-Disposition' =>
                    'inline; filename="salon-qr.svg"',

                'Cache-Control' =>
                    'private, max-age=3600',

                'X-Content-Type-Options' =>
                    'nosniff',
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Download
    |--------------------------------------------------------------------------
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

        $svg = $this->renderQr(
            $url,
            12
        );

        $filename =
            Str::slug(
                $salon->name ?: 'salon'
            ) . '-qr.svg';

        return response(
            $svg,
            200,
            [
                'Content-Type' =>
                    'image/svg+xml; charset=UTF-8',

                'Content-Disposition' =>
                    'attachment; filename="' . $filename . '"',

                'Cache-Control' =>
                    'no-cache, no-store, must-revalidate',

                'X-Content-Type-Options' =>
                    'nosniff',
            ]
        );
    }
}
