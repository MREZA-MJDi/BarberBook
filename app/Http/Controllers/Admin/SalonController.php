<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSalonRequest;
use App\Http\Requests\Admin\UpdateSalonRequest;
use App\Models\Salon;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SalonController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Hero Image Settings
    |--------------------------------------------------------------------------
    |
    | Every uploaded Hero image is converted to this exact size.
    |
    */

    private const HERO_WIDTH = 1920;

    private const HERO_HEIGHT = 900;

    private const HERO_QUALITY = 82;


    /*
    |--------------------------------------------------------------------------
    | Index
    |--------------------------------------------------------------------------
    */

    /**
     * Display all salons.
     */
    public function index(Request $request): View
    {
        $query = Salon::query()
            ->with('user')
            ->latest('id');

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = trim(
                $request->input('search')
            );

            $query->where(function ($query) use ($search) {

                $query
                    ->where(
                        'name',
                        'like',
                        '%' . $search . '%'
                    )
                    ->orWhere(
                        'phone',
                        'like',
                        '%' . $search . '%'
                    )
                    ->orWhere(
                        'slug',
                        'like',
                        '%' . $search . '%'
                    )
                    ->orWhereHas(
                        'user',
                        function ($userQuery) use ($search) {

                            $userQuery
                                ->where(
                                    'full_name',
                                    'like',
                                    '%' . $search . '%'
                                )
                                ->orWhere(
                                    'email',
                                    'like',
                                    '%' . $search . '%'
                                )
                                ->orWhere(
                                    'phone',
                                    'like',
                                    '%' . $search . '%'
                                );

                        }
                    );

            });
        }

        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        $salons = $query
            ->paginate(15)
            ->withQueryString();

        return view(
            'admin.salons.index',
            compact('salons')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Create
    |--------------------------------------------------------------------------
    */

    /**
     * Show create salon form.
     */
    public function create(): View
    {
        return view(
            'admin.salons.create'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Store
    |--------------------------------------------------------------------------
    */

    /**
     * Create barber account, salon, QR and branding.
     */
    public function store(
        StoreSalonRequest $request
    ): RedirectResponse {
        $validated = $request->validated();

        /*
        |--------------------------------------------------------------------------
        | Logo
        |--------------------------------------------------------------------------
        */

        $logoPath = $this->storeImage(
            $request->file('logo'),
            'salons/logos'
        );


        /*
        |--------------------------------------------------------------------------
        | Hero Cover
        |--------------------------------------------------------------------------
        |
        | The original image is NOT stored.
        |
        | It is converted to:
        |
        | 1920 x 900
        | WebP
        |
        */

        $coverPath = $this->processHeroImage(
            $request->file('cover')
        );


        try {

            /*
            |--------------------------------------------------------------------------
            | Create User + Salon
            |--------------------------------------------------------------------------
            */

            $salon = DB::transaction(
                function () use (
                    $validated,
                    $logoPath,
                    $coverPath
                ) {

                    /*
                    |--------------------------------------------------------------------------
                    | Barber
                    |--------------------------------------------------------------------------
                    |
                    | 1 = Super Admin
                    | 2 = Barber
                    |
                    */

                    $user = User::create([

                        'role_id' => 2,

                        'full_name' =>
                            $validated['full_name'],

                        'phone' =>
                            $validated['user_phone'],

                        'email' =>
                            $validated['email'],

                        'password' =>
                            Hash::make(
                                $validated['password']
                            ),

                    ]);


                    /*
                    |--------------------------------------------------------------------------
                    | Salon
                    |--------------------------------------------------------------------------
                    */

                    return Salon::create([

                        'user_id' =>
                            $user->id,

                        'name' =>
                            $validated['name'],

                        'slug' =>
                            $this->generateUniqueSlug(
                                $validated['name']
                            ),

                        /*
                        |--------------------------------------------------------------------------
                        | QR
                        |--------------------------------------------------------------------------
                        */

                        'qr_token' =>
                            $this->generateUniqueQrToken(),

                        /*
                        |--------------------------------------------------------------------------
                        | Contact
                        |--------------------------------------------------------------------------
                        */

                        'phone' =>
                            $validated['phone'] ?? null,

                        'address' =>
                            $validated['address'] ?? null,

                        'instagram' =>
                            $validated['instagram'] ?? null,

                        'description' =>
                            $validated['description'] ?? null,

                        /*
                        |--------------------------------------------------------------------------
                        | Branding
                        |--------------------------------------------------------------------------
                        */

                        'logo' =>
                            $logoPath,

                        'cover' =>
                            $coverPath,

                        /*
                        |--------------------------------------------------------------------------
                        | Status
                        |--------------------------------------------------------------------------
                        */

                        'is_active' =>
                            true,

                    ]);

                }
            );

        } catch (\Throwable $e) {

            /*
            |--------------------------------------------------------------------------
            | Cleanup Files If Database Fails
            |--------------------------------------------------------------------------
            */

            $this->deleteImage(
                $logoPath
            );

            $this->deleteImage(
                $coverPath
            );

            throw $e;
        }


        /*
        |--------------------------------------------------------------------------
        | Success
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'admin.salons.index'
            )
            ->with(
                'success',
                "سالن «{$salon->name}»، حساب آرایشگر، QR Code و تصویر Hero با موفقیت ساخته شدند."
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Edit
    |--------------------------------------------------------------------------
    */

    /**
     * Show salon edit form.
     */
    public function edit(
        Salon $salon
    ): View {
        $salon->load('user');

        return view(
            'admin.salons.edit',
            compact('salon')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Update
    |--------------------------------------------------------------------------
    */

    /**
     * Update salon, barber account and branding.
     */
    public function update(
        UpdateSalonRequest $request,
        Salon $salon
    ): RedirectResponse {
        $validated = $request->validated();


        /*
        |--------------------------------------------------------------------------
        | Owner
        |--------------------------------------------------------------------------
        */

        $user = $salon->user;

        abort_if(
            !$user,
            404,
            'مالک این سالن پیدا نشد.'
        );


        /*
        |--------------------------------------------------------------------------
        | Existing Images
        |--------------------------------------------------------------------------
        */

        $oldLogoPath = $salon->logo;

        $oldCoverPath = $salon->cover;


        /*
        |--------------------------------------------------------------------------
        | New Images
        |--------------------------------------------------------------------------
        */

        $newLogoPath = null;

        $newCoverPath = null;


        try {

            /*
            |--------------------------------------------------------------------------
            | New Logo
            |--------------------------------------------------------------------------
            */

            if ($request->hasFile('logo')) {

                $newLogoPath = $this->storeImage(
                    $request->file('logo'),
                    'salons/logos'
                );
            }


            /*
            |--------------------------------------------------------------------------
            | New Hero
            |--------------------------------------------------------------------------
            */

            if ($request->hasFile('cover')) {

                $newCoverPath =
                    $this->processHeroImage(
                        $request->file('cover')
                    );
            }


            /*
            |--------------------------------------------------------------------------
            | Update Database
            |--------------------------------------------------------------------------
            */

            DB::transaction(
                function () use (
                    $validated,
                    $request,
                    $salon,
                    $user,
                    $newLogoPath,
                    $newCoverPath
                ) {

                    /*
                    |--------------------------------------------------------------------------
                    | User
                    |--------------------------------------------------------------------------
                    */

                    $userData = [

                        'full_name' =>
                            $validated['full_name'],

                        'phone' =>
                            $validated['user_phone'],

                        'email' =>
                            $validated['email'],

                    ];


                    /*
                    |--------------------------------------------------------------------------
                    | Optional Password
                    |--------------------------------------------------------------------------
                    */

                    if (
                        filled(
                            $validated['password'] ?? null
                        )
                    ) {

                        $userData['password'] =
                            Hash::make(
                                $validated['password']
                            );
                    }


                    $user->update(
                        $userData
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | Salon
                    |--------------------------------------------------------------------------
                    */

                    $salonData = [

                        'name' =>
                            $validated['name'],

                        'phone' =>
                            $validated['phone'] ?? null,

                        'address' =>
                            $validated['address'] ?? null,

                        'instagram' =>
                            $validated['instagram'] ?? null,

                        'description' =>
                            $validated['description'] ?? null,

                        'is_active' =>
                            $request->boolean(
                                'is_active'
                            ),

                    ];


                    /*
                    |--------------------------------------------------------------------------
                    | Logo
                    |--------------------------------------------------------------------------
                    */

                    if ($newLogoPath !== null) {

                        $salonData['logo'] =
                            $newLogoPath;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Hero
                    |--------------------------------------------------------------------------
                    */

                    if ($newCoverPath !== null) {

                        $salonData['cover'] =
                            $newCoverPath;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Save Salon
                    |--------------------------------------------------------------------------
                    |
                    | QR token intentionally stays unchanged.
                    |
                    */

                    $salon->update(
                        $salonData
                    );

                }
            );


            /*
            |--------------------------------------------------------------------------
            | Delete Old Logo
            |--------------------------------------------------------------------------
            */

            if (
                $newLogoPath !== null &&
                filled($oldLogoPath)
            ) {

                $this->deleteImage(
                    $oldLogoPath
                );
            }


            /*
            |--------------------------------------------------------------------------
            | Delete Old Hero
            |--------------------------------------------------------------------------
            */

            if (
                $newCoverPath !== null &&
                filled($oldCoverPath)
            ) {

                $this->deleteImage(
                    $oldCoverPath
                );
            }

        } catch (\Throwable $e) {

            /*
            |--------------------------------------------------------------------------
            | Cleanup New Files
            |--------------------------------------------------------------------------
            */

            $this->deleteImage(
                $newLogoPath
            );

            $this->deleteImage(
                $newCoverPath
            );

            throw $e;
        }


        /*
        |--------------------------------------------------------------------------
        | Success
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'admin.salons.index'
            )
            ->with(
                'success',
                'اطلاعات سالن، آرایشگر و تصاویر با موفقیت بروزرسانی شد.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Destroy
    |--------------------------------------------------------------------------
    */

    /**
     * Delete salon and barber account.
     */
    public function destroy(
        Salon $salon
    ): RedirectResponse {
        $user = $salon->user;

        $logoPath = $salon->logo;

        $coverPath = $salon->cover;


        DB::transaction(
            function () use (
                $salon,
                $user
            ) {

                /*
                |--------------------------------------------------------------------------
                | Delete Salon
                |--------------------------------------------------------------------------
                */

                $salon->delete();


                /*
                |--------------------------------------------------------------------------
                | Delete Owner
                |--------------------------------------------------------------------------
                */

                if ($user) {
                    $user->delete();
                }

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Delete Images
        |--------------------------------------------------------------------------
        */

        $this->deleteImage(
            $logoPath
        );

        $this->deleteImage(
            $coverPath
        );


        return redirect()
            ->route(
                'admin.salons.index'
            )
            ->with(
                'success',
                'سالن، حساب آرایشگر و تصاویر با موفقیت حذف شدند.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Store Normal Image
    |--------------------------------------------------------------------------
    */

    /**
     * Store normal uploaded image.
     */
    private function storeImage(
        ?UploadedFile $file,
        string $directory
    ): ?string {
        if (!$file) {
            return null;
        }

        return $file->store(
            $directory,
            'public'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Process Hero Image
    |--------------------------------------------------------------------------
    */

    /**
     * Convert uploaded Hero image to:
     *
     * 1920 x 900
     * WebP
     *
     * The image is cropped proportionally so it is never stretched.
     */
    private function processHeroImage(
        ?UploadedFile $file
    ): ?string {
        if (!$file) {
            return null;
        }


        /*
        |--------------------------------------------------------------------------
        | Read Original Image
        |--------------------------------------------------------------------------
        */

        $contents = file_get_contents(
            $file->getRealPath()
        );

        if ($contents === false) {

            throw new \RuntimeException(
                'امکان خواندن تصویر Hero وجود ندارد.'
            );
        }


        $source = @imagecreatefromstring(
            $contents
        );

        if (!$source) {

            throw new \RuntimeException(
                'فرمت تصویر Hero پشتیبانی نمی‌شود.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Original Dimensions
        |--------------------------------------------------------------------------
        */

        $sourceWidth =
            imagesx($source);

        $sourceHeight =
            imagesy($source);


        if (
            $sourceWidth < 1 ||
            $sourceHeight < 1
        ) {

            imagedestroy($source);

            throw new \RuntimeException(
                'ابعاد تصویر Hero معتبر نیست.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Target Dimensions
        |--------------------------------------------------------------------------
        */

        $targetWidth =
            self::HERO_WIDTH;

        $targetHeight =
            self::HERO_HEIGHT;


        /*
        |--------------------------------------------------------------------------
        | Calculate Crop
        |--------------------------------------------------------------------------
        |
        | Target ratio:
        |
        | 1920 / 900
        | = 2.1333
        |
        | We crop the original image to this ratio.
        |
        */

        $sourceRatio =
            $sourceWidth / $sourceHeight;

        $targetRatio =
            $targetWidth / $targetHeight;


        if ($sourceRatio > $targetRatio) {

            /*
            |--------------------------------------------------------------------------
            | Source is wider.
            |--------------------------------------------------------------------------
            |
            | Crop left/right.
            |
            */

            $cropHeight =
                $sourceHeight;

            $cropWidth =
                (int) round(
                    $sourceHeight *
                    $targetRatio
                );

            $sourceX =
                (int) floor(
                    ($sourceWidth - $cropWidth) / 2
                );

            $sourceY = 0;

        } else {

            /*
            |--------------------------------------------------------------------------
            | Source is taller.
            |--------------------------------------------------------------------------
            |
            | Crop top/bottom.
            |
            */

            $cropWidth =
                $sourceWidth;

            $cropHeight =
                (int) round(
                    $sourceWidth /
                    $targetRatio
                );

            $sourceX = 0;

            $sourceY =
                (int) floor(
                    ($sourceHeight - $cropHeight) / 2
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Create Target Canvas
        |--------------------------------------------------------------------------
        */

        $destination =
            imagecreatetruecolor(
                $targetWidth,
                $targetHeight
            );


        if (!$destination) {

            imagedestroy($source);

            throw new \RuntimeException(
                'ساخت تصویر Hero امکان‌پذیر نیست.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Image Quality
        |--------------------------------------------------------------------------
        */

        imagealphablending(
            $destination,
            true
        );

        imagesavealpha(
            $destination,
            false
        );


        /*
        |--------------------------------------------------------------------------
        | Resize + Crop
        |--------------------------------------------------------------------------
        */

        $success = imagecopyresampled(
            $destination,
            $source,

            0,
            0,

            $sourceX,
            $sourceY,

            $targetWidth,
            $targetHeight,

            $cropWidth,
            $cropHeight
        );


        if (!$success) {

            imagedestroy($source);
            imagedestroy($destination);

            throw new \RuntimeException(
                'پردازش تصویر Hero با خطا مواجه شد.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Encode WebP
        |--------------------------------------------------------------------------
        */

        ob_start();

        $webpCreated = imagewebp(
            $destination,
            null,
            self::HERO_QUALITY
        );

        $webpData = ob_get_clean();


        /*
        |--------------------------------------------------------------------------
        | Free Memory
        |--------------------------------------------------------------------------
        */

        imagedestroy(
            $source
        );

        imagedestroy(
            $destination
        );


        if (
            !$webpCreated ||
            !$webpData
        ) {

            throw new \RuntimeException(
                'تبدیل تصویر Hero به WebP انجام نشد.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Generate Filename
        |--------------------------------------------------------------------------
        */

        $filename =
            Str::uuid()->toString() .
            '.webp';


        $path =
            'salons/covers/' .
            $filename;


        /*
        |--------------------------------------------------------------------------
        | Store WebP
        |--------------------------------------------------------------------------
        */

        $stored = Storage::disk('public')
            ->put(
                $path,
                $webpData
            );


        if (!$stored) {

            throw new \RuntimeException(
                'ذخیره تصویر Hero امکان‌پذیر نیست.'
            );
        }


        return $path;
    }


    /*
    |--------------------------------------------------------------------------
    | Delete Image
    |--------------------------------------------------------------------------
    */

    /**
     * Delete image from public disk.
     */
    private function deleteImage(
        ?string $path
    ): void {
        if (
            filled($path) &&
            Storage::disk('public')->exists($path)
        ) {

            Storage::disk('public')->delete(
                $path
            );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Generate Unique Slug
    |--------------------------------------------------------------------------
    */

    /**
     * Generate unique salon slug.
     */
    private function generateUniqueSlug(
        string $name
    ): string {
        $baseSlug = Str::slug(
            $name
        );


        /*
        |--------------------------------------------------------------------------
        | Persian Name Fallback
        |--------------------------------------------------------------------------
        */

        if ($baseSlug === '') {

            $baseSlug =
                'salon-' .
                Str::lower(
                    Str::random(8)
                );
        }


        $slug = $baseSlug;

        $counter = 1;


        /*
        |--------------------------------------------------------------------------
        | Ensure Unique
        |--------------------------------------------------------------------------
        */

        while (
        Salon::query()
            ->where(
                'slug',
                $slug
            )
            ->exists()
        ) {

            $slug =
                $baseSlug .
                '-' .
                $counter;

            $counter++;
        }


        return $slug;
    }


    /*
    |--------------------------------------------------------------------------
    | Generate Unique QR Token
    |--------------------------------------------------------------------------
    */

    /**
     * Generate unique QR token.
     */
    private function generateUniqueQrToken(): string
    {
        do {

            $token =
                'BB-' .
                strtoupper(
                    Str::random(16)
                );

        } while (
            Salon::query()
                ->where(
                    'qr_token',
                    $token
                )
                ->exists()
        );


        return $token;
    }
}
