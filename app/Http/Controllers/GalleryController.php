<?php

namespace App\Http\Controllers;

use App\Models\GalleryItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class GalleryController extends Controller
{
    public function index(): View
    {
        $salon = auth()->user()->salon;

        abort_unless($salon, 404);

        $galleryItems = $salon->galleryItems()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return view('dashboard.gallery.index', [
            'salon' => $salon,
            'galleryItems' => $galleryItems,
        ]);
    }

    public function create(): View
    {
        $salon = auth()->user()->salon;

        abort_unless($salon, 404);

        return view('dashboard.gallery.create', [
            'salon' => $salon,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $salon = auth()->user()->salon;

        abort_unless($salon, 404);

        $validated = $request->validate([
            'image' => [
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
        ]);

        $path = $request->file('image')->store(
            'gallery',
            'public'
        );

        $salon->galleryItems()->create([
            'image_path' => $path,
            'title' => $validated['title'] ?? null,
            'alt_text' => $validated['alt_text'] ?? null,
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()
            ->route('gallery.index')
            ->with('success', 'تصویر با موفقیت به گالری اضافه شد.');
    }

    public function edit(GalleryItem $galleryItem): View
    {
        $salon = auth()->user()->salon;

        abort_unless(
            $salon && $galleryItem->salon_id === $salon->id,
            404
        );

        return view('dashboard.gallery.edit', [
            'salon' => $salon,
            'galleryItem' => $galleryItem,
        ]);
    }

    public function update(
        Request $request,
        GalleryItem $galleryItem
    ): RedirectResponse {
        $salon = auth()->user()->salon;

        abort_unless(
            $salon && $galleryItem->salon_id === $salon->id,
            404
        );

        $validated = $request->validate([
            'image' => [
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
        ]);

        $data = [
            'title' => $validated['title'] ?? null,
            'alt_text' => $validated['alt_text'] ?? null,
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->boolean('is_active'),
        ];

        if ($request->hasFile('image')) {
            $newPath = $request->file('image')->store(
                'gallery',
                'public'
            );

            if (
                $galleryItem->image_path &&
                Storage::disk('public')->exists($galleryItem->image_path)
            ) {
                Storage::disk('public')->delete(
                    $galleryItem->image_path
                );
            }

            $data['image_path'] = $newPath;
        }

        $galleryItem->update($data);

        return redirect()
            ->route('gallery.index')
            ->with('success', 'تصویر با موفقیت ویرایش شد.');
    }

    public function destroy(
        GalleryItem $galleryItem
    ): RedirectResponse {
        $salon = auth()->user()->salon;

        abort_unless(
            $salon && $galleryItem->salon_id === $salon->id,
            404
        );

        if (
            $galleryItem->image_path &&
            Storage::disk('public')->exists($galleryItem->image_path)
        ) {
            Storage::disk('public')->delete($galleryItem->image_path);
        }

        $galleryItem->delete();

        return redirect()
            ->route('gallery.index')
            ->with('success', 'تصویر حذف شد.');
    }
}
