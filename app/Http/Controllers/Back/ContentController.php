<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\ContentSection;
use App\Models\ContentDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $contents = ContentSection::orderBy('order', 'asc');
        if (@$request->input('title')) {
            $title = str_replace(' ', '%', $request->input('title'));
            $contents->where('title', 'like', '%' . $title . '%');
        }
        if (@$request->input('section_type')) {
            $section_type = $request->input('section_type');
            $contents->where('section_type', $section_type);
        }
        if (@$request->input('status')) {
            $status = $request->input('status');
            $contents->where('status', $status);
        }
        $contents = $contents
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('back.content_management.index', compact('contents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Render the create form that lives in resources/views/back/content_management/create.blade.php
        return view('back.content_management.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'section_type' => 'required|in:content,product,testimonials,contact,hero',
            'has_button' => 'sometimes|boolean',
            'buttons_count' => 'nullable|integer|min:0',
            'buttons' => 'nullable|array',
            'buttons.*.label' => 'nullable|string|max:255',
            'buttons.*.url' => 'nullable|string|max:2048',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            // details when section_type == content
            'details' => 'nullable|array',
            'details.*.category' => 'nullable|string|max:100',
            'details.*.title' => 'nullable|string|max:255',
            'details.*.description' => 'nullable|string',
            'details.*.icon' => 'nullable|string|max:255',
            'details.*.additional' => 'nullable|string',
            'details.*.order' => 'nullable|integer',
            'details.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'status' => 'required|in:draft,publish,archive',
            'order' => 'nullable|integer',
        ]);

        // Prepare data matching the contents table
        $data = [
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'section_type' => $validated['section_type'],
            'has_button' => $request->boolean('has_button'),
            'buttons_count' => $validated['buttons_count'] ?? 0,
            'buttons' => !empty($validated['buttons']) ? array_values($validated['buttons']) : null,
            'status' => $validated['status'],
            'order' => $validated['order'] ?? 0,
        ];

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('contents', 'public');
        }

        // If buttons_count not provided, compute from buttons array
        if (empty($data['buttons_count']) && is_array($data['buttons'])) {
            $data['buttons_count'] = count($data['buttons']);
        }

        $section = ContentSection::create($data);

        // If the section is of type 'content', persist any provided details
        if (($validated['section_type'] ?? null) === 'content' && $request->has('details')) {
            $details = $request->input('details', []);
            foreach ($details as $i => $d) {
                $category = $d['category'] ?? null;
                $title = $d['title'] ?? null;
                $description = $d['description'] ?? null;
                $order = isset($d['order']) ? (int)$d['order'] : 0;

                // additional: try decode JSON, otherwise store as text
                $additional = null;
                if (isset($d['additional']) && $d['additional'] !== null && $d['additional'] !== '') {
                    $maybe = json_decode($d['additional'], true);
                    $additional = ($maybe === null) ? ['text' => $d['additional']] : $maybe;
                }

                $icon = $d['icon'] ?? null;
                $imagePath = null;

                // handle uploaded file for this detail (if any)
                $file = $request->file("details.$i.image");
                if ($category === 'about') {
                    // about uses image instead of icon
                    $icon = null;
                    if ($file) {
                        $imagePath = $file->store('content_details', 'public');
                    }
                } else {
                    // non-about categories may still have uploaded image (optional)
                    if ($file) {
                        $imagePath = $file->store('content_details', 'public');
                    }
                }

                ContentDetail::create([
                    'category' => $category,
                    'content_id' => $section->id,
                    'icon' => $icon,
                    'image' => $imagePath,
                    'title' => $title,
                    'description' => $description,
                    'additional' => $additional,
                    'order' => $order,
                ]);
            }
        }

        return redirect(url('content-management'))
            ->with('success', 'Content berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ContentSection $content)
    {
        return view('back.content_management.show', compact('content'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Fetch the content section by id and ensure details are loaded (and ordered)
        $content = ContentSection::with(['details' => function ($q) {
            $q->orderBy('order', 'asc');
        }])->findOrFail($id);

        return view('back.content_management.edit', compact('content'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $content = ContentSection::findOrFail($id);

        \Log::info('Update request received', [
            'request_all' => $request->all(),
            'content_id' => $content->id
        ]);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'section_type' => 'required|in:content,product,testimonials,contact,hero',
            'has_button' => 'sometimes|boolean',
            'buttons_count' => 'nullable|integer|min:0',
            'buttons' => 'nullable|array',
            'buttons.*.label' => 'nullable|string|max:255',
            'buttons.*.url' => 'nullable|string|max:2048',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            // details validation for update as well
            'details' => 'nullable|array',
            'details.*.id' => 'nullable|integer',
            'details.*.category' => 'nullable|string|max:100',
            'details.*.title' => 'nullable|string|max:255',
            'details.*.description' => 'nullable|string',
            'details.*.icon' => 'nullable|string|max:255',
            'details.*.additional' => 'nullable|string',
            'details.*.order' => 'nullable|integer',
            'details.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'status' => 'required|in:draft,publish,archive',
            'order' => 'nullable|integer',
        ]);

        $data = [
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'section_type' => $validated['section_type'],
            'has_button' => $request->boolean('has_button'),
            'buttons_count' => $validated['buttons_count'] ?? 0,
            'buttons' => !empty($validated['buttons']) ? array_values($validated['buttons']) : null,
            'status' => $validated['status'],
            'order' => $validated['order'] ?? 0,
        ];

        if ($request->hasFile('image')) {
            if ($content->image) {
                Storage::disk('public')->delete($content->image);
            }
            $data['image'] = $request->file('image')->store('contents', 'public');
        }

        if (empty($data['buttons_count']) && is_array($data['buttons'])) {
            $data['buttons_count'] = count($data['buttons']);
        }

        try {
            \Log::info('Attempting to update content', [
                'content_id' => $content->id,
                'data' => $data,
                'content_exists' => $content->exists
            ]);

            $result = $content->update($data);

            \Log::info('Update result', [
                'success' => $result,
                'content_after' => $content->fresh()->toArray()
            ]);
        } catch (\Exception $e) {
            \Log::error('Error updating content', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan saat mengupdate content: ' . $e->getMessage()]);
        }

        // Sync details when section_type == content
        if (($validated['section_type'] ?? null) === 'content') {
            $incoming = $request->input('details', []);

            // collect incoming ids
            $incomingIds = [];
            foreach ($incoming as $i => $d) {
                if (!empty($d['id'])) {
                    $incomingIds[] = (int)$d['id'];
                }
            }

            $existingIds = $content->details()->pluck('id')->toArray();

            // delete removed details
            $toDelete = array_diff($existingIds, $incomingIds);
            foreach ($toDelete as $delId) {
                $det = ContentDetail::find($delId);
                if ($det) {
                    if ($det->image) {
                        Storage::disk('public')->delete($det->image);
                    }
                    $det->delete();
                }
            }

            // process incoming (update or create)
            foreach ($incoming as $i => $d) {
                $detId = !empty($d['id']) ? (int)$d['id'] : null;
                $category = $d['category'] ?? null;
                $title = $d['title'] ?? null;
                $description = $d['description'] ?? null;
                $order = isset($d['order']) ? (int)$d['order'] : 0;

                $additional = null;
                if (isset($d['additional']) && $d['additional'] !== null && $d['additional'] !== '') {
                    $maybe = json_decode($d['additional'], true);
                    $additional = ($maybe === null) ? ['text' => $d['additional']] : $maybe;
                }

                $icon = $d['icon'] ?? null;
                $imagePath = null;

                $file = $request->file("details.$i.image");

                if ($detId) {
                    $det = ContentDetail::find($detId);
                    if (!$det) {
                        // skip if not found
                        continue;
                    }

                    // handle file replacement
                    if ($file) {
                        if ($det->image) {
                            Storage::disk('public')->delete($det->image);
                        }
                        $imagePath = $file->store('content_details', 'public');
                    }

                    if ($category === 'about') {
                        $icon = null;
                    }

                    $det->update([
                        'category' => $category,
                        'icon' => $icon,
                        'image' => $imagePath ?? $det->image,
                        'title' => $title,
                        'description' => $description,
                        'additional' => $additional,
                        'order' => $order,
                    ]);
                } else {
                    // new detail
                    if ($file) {
                        $imagePath = $file->store('content_details', 'public');
                    }

                    if ($category === 'about') {
                        $icon = null;
                    }

                    ContentDetail::create([
                        'category' => $category,
                        'content_id' => $content->id,
                        'icon' => $icon,
                        'image' => $imagePath,
                        'title' => $title,
                        'description' => $description,
                        'additional' => $additional,
                        'order' => $order,
                    ]);
                }
            }
        } else {
            // if section type is not content, remove any existing details
            foreach ($content->details as $det) {
                if ($det->image) {
                    Storage::disk('public')->delete($det->image);
                }
                $det->delete();
            }
        }

        if ($result) {
            return redirect(url('content-management'))
                ->with('success', 'Content berhasil diupdate.');
        }

        return redirect()->back()
            ->withInput()
            ->withErrors(['error' => 'Gagal mengupdate content. Silakan coba lagi.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContentSection $content)
    {
        // Hapus gambar jika ada
        if ($content->image) {
            Storage::disk('public')->delete($content->image);
        }

        $content->delete();

        return redirect(url('content-management'))
            ->with('success', 'Content berhasil dihapus.');
    }

    /**
     * Publish the specified content (set status = 'publish').
     */
    public function publish(Request $request, $id)
    {
        $content = ContentSection::findOrFail($id);

        try {
            $content->status = 'publish';
            $content->save();
        } catch (\Exception $e) {
            \Log::error('Failed to publish content', ['id' => $id, 'error' => $e->getMessage()]);
            return redirect()->back()->withErrors(['error' => 'Gagal mempublish content.']);
        }

        return redirect(url('content-management'))
            ->with('success', 'Content berhasil dipublish.');
    }

    /**
     * Unpublish the specified content (set status = 'draft').
     */
    public function unpublish(Request $request, $id)
    {
        $content = ContentSection::findOrFail($id);

        try {
            $content->status = 'draft';
            $content->save();
        } catch (\Exception $e) {
            \Log::error('Failed to unpublish content', ['id' => $id, 'error' => $e->getMessage()]);
            return redirect()->back()->withErrors(['error' => 'Gagal mengubah status content.']);
        }

        return redirect(url('content-management'))
            ->with('success', 'Content berhasil diubah menjadi draft.');
    }
}
