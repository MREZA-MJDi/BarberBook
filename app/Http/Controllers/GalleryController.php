<?php

namespace App\Http\Controllers;

use App\Models\GalleryItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class GalleryController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Index
    |--------------------------------------------------------------------------
    */

    /**
     * Display salon gallery.
     *
     * Ten items per page.
     */
    public function index(): View
    {
        $salon = auth()->user()->salon;

        abort_unless(
            $salon,
            404
        );


        $galleryItems = $salon
            ->galleryItems()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->paginate(10)
            ->withQueryString();


        return view(
            'dashboard.gallery.index',
            [
                'salon' => $salon,
                'galleryItems' => $galleryItems,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Create
    |--------------------------------------------------------------------------
    */

    /**
     * Show create gallery form.
     */
    public function create(): View
    {
        $salon = auth()->user()->salon;

        abort_unless(
            $salon,
            404
        );


        return view(
            'dashboard.gallery.create',
            [
                'salon' => $salon,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Store
    |--------------------------------------------------------------------------
    */

    /**
     * Store a new before/after gallery item.
     */
    public function store(
        Request $request
    ): RedirectResponse {
        $salon = auth()->user()->salon;

        abort_unless($salon, 404);

        $validated = $request->validate([
            'before_image' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'after_image' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'title' => [
                'nullable',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
                'max:2000',
            ],

            'alt_text' => [
                'nullable',
                'string',
                'max:255',
            ],

            'sort_order' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'is_active' => [
                'nullable',
                'boolean',
            ],
        ]);


        $beforePath = null;
        $afterPath = null;

        try {

            $beforePath = $request
                ->file('before_image')
                ->store(
                    'gallery/before',
                    'public'
                );

            $afterPath = $request
                ->file('after_image')
                ->store(
                    'gallery/after',
                    'public'
                );


            $salon->galleryItems()->create([
                'before_image' => $beforePath,

                'after_image' => $afterPath,

                'title' =>
                    $validated['title'] ?? null,

                'description' =>
                    $validated['description'] ?? null,

                'alt_text' =>
                    $validated['alt_text'] ?? null,

                'sort_order' =>
                    $validated['sort_order'] ?? 0,

                'is_active' =>
                    $request->boolean(
                        'is_active',
                        true
                    ),
            ]);

        } catch (\Throwable $e) {

            if ($beforePath) {
                Storage::disk('public')->delete($beforePath);
            }

            if ($afterPath) {
                Storage::disk('public')->delete($afterPath);
            }

            throw $e;
        }


        return redirect()
            ->route('gallery.index')
            ->with(
                'success',
                'نمونه‌کار قبل و بعد با موفقیت به گالری اضافه شد.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Edit
    |--------------------------------------------------------------------------
    */

    /**
     * Show edit gallery form.
     */
    public function edit(
        GalleryItem $galleryItem
    ): View {
        $salon = auth()->user()->salon;

        abort_unless(
            $salon &&
            $galleryItem->salon_id === $salon->id,
            404
        );


        return view(
            'dashboard.gallery.edit',
            [
                'salon' => $salon,
                'galleryItem' => $galleryItem,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Update
    |--------------------------------------------------------------------------
    */

    /**
     * Update gallery item.
     */
    public function update(
        Request $request,
        GalleryItem $galleryItem
    ): RedirectResponse {
        $salon = auth()->user()->salon;

        abort_unless(
            $salon &&
            $galleryItem->salon_id === $salon->id,
            404
        );


        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([

            'before_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'after_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'title' => [
                'nullable',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
                'max:2000',
            ],

            'alt_text' => [
                'nullable',
                'string',
                'max:255',
            ],

            'sort_order' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'is_active' => [
                'nullable',
                'boolean',
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | Existing Files
        |--------------------------------------------------------------------------
        */

        $oldBeforePath =
            $galleryItem->before_image;

        $oldAfterPath =
            $galleryItem->after_image;


        /*
        |--------------------------------------------------------------------------
        | New Files
        |--------------------------------------------------------------------------
        */

        $newBeforePath = null;

        $newAfterPath = null;


        try {

            /*
            |--------------------------------------------------------------------------
            | New Before
            |--------------------------------------------------------------------------
            */

            if ($request->hasFile('before_image')) {

                $newBeforePath = $request
                    ->file('before_image')
                    ->store(
                        'gallery/before',
                        'public'
                    );
            }


            /*
            |--------------------------------------------------------------------------
            | New After
            |--------------------------------------------------------------------------
            */

            if ($request->hasFile('after_image')) {

                $newAfterPath = $request
                    ->file('after_image')
                    ->store(
                        'gallery/after',
                        'public'
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
                    $galleryItem,
                    $newBeforePath,
                    $newAfterPath
                ) {

                    $data = [

                        'title' =>
                            $validated['title'] ?? null,

                        'description' =>
                            $validated['description'] ?? null,

                        'alt_text' =>
                            $validated['alt_text'] ?? null,

                        'sort_order' =>
                            $validated['sort_order'] ?? 0,

                        'is_active' =>
                            $request->boolean(
                                'is_active'
                            ),

                    ];


                    /*
                    |--------------------------------------------------------------------------
                    | Before
                    |--------------------------------------------------------------------------
                    */

                    if ($newBeforePath !== null) {

                        $data['before_image'] =
                            $newBeforePath;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | After
                    |--------------------------------------------------------------------------
                    */

                    if ($newAfterPath !== null) {

                        $data['after_image'] =
                            $newAfterPath;
                    }


                    $galleryItem->update(
                        $data
                    );

                }
            );


            /*
            |--------------------------------------------------------------------------
            | Delete Old Before
            |--------------------------------------------------------------------------
            */

            if (
                $newBeforePath !== null &&
                filled($oldBeforePath)
            ) {

                $this->deleteImage(
                    $oldBeforePath
                );
            }


            /*
            |--------------------------------------------------------------------------
            | Delete Old After
            |--------------------------------------------------------------------------
            */

            if (
                $newAfterPath !== null &&
                filled($oldAfterPath)
            ) {

                $this->deleteImage(
                    $oldAfterPath
                );
            }

        } catch (\Throwable $e) {

            /*
            |--------------------------------------------------------------------------
            | Cleanup New Files
            |--------------------------------------------------------------------------
            */

            $this->deleteImage(
                $newBeforePath
            );

            $this->deleteImage(
                $newAfterPath
            );

            throw $e;
        }


        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'gallery.index'
            )
            ->with(
                'success',
                'نمونه‌کار با موفقیت بروزرسانی شد.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Destroy
    |--------------------------------------------------------------------------
    */

    /**
     * Delete gallery item and both images.
     */
    public function destroy(
        GalleryItem $galleryItem
    ): RedirectResponse {
        $salon = auth()->user()->salon;

        abort_unless(
            $salon &&
            $galleryItem->salon_id === $salon->id,
            404
        );


        /*
        |--------------------------------------------------------------------------
        | Existing Files
        |--------------------------------------------------------------------------
        */

        $beforePath =
            $galleryItem->before_image;

        $afterPath =
            $galleryItem->after_image;


        /*
        |--------------------------------------------------------------------------
        | Delete Record
        |--------------------------------------------------------------------------
        */

        $galleryItem->delete();


        /*
        |--------------------------------------------------------------------------
        | Delete Files
        |--------------------------------------------------------------------------
        */

        $this->deleteImage(
            $beforePath
        );

        $this->deleteImage(
            $afterPath
        );


        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'gallery.index'
            )
            ->with(
                'success',
                'نمونه‌کار و تصاویر آن با موفقیت حذف شدند.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Delete Image Helper
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
}
