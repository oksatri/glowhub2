<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Content;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ContentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Content::with('category');

        // Filter berdasarkan search
        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('content', 'like', '%' . $request->search . '%');
            });
        }

        // Filter berdasarkan kategori
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        // Filter berdasarkan status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan tipe
        if ($request->has('type') && $request->type) {
            $query->where('type', $request->type);
        }

        $contents = $query->latest()->paginate(10);
        $categories = Category::active()->ordered()->get();

        return view('templates.back.admin.content.index', compact('contents', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::active()->ordered()->get();
        return view('templates.back.admin.content.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:contents,slug',
            'excerpt' => 'nullable|string',
            'content' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'nullable|exists:categories,id',
            'type' => 'required|in:page,article,service,portfolio,other',
            'status' => 'required|in:draft,published,archived',
            'is_featured' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'sort_order' => 'nullable|integer',
        ]);

        $data = $request->all();

        // Generate slug jika tidak ada
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('contents', 'public');
        }

        // Set published_at jika status published
        if ($data['status'] === 'published' && !isset($data['published_at'])) {
            $data['published_at'] = now();
        }

        Content::create($data);

        return redirect()->route('admin.content.index')
            ->with('success', 'Content berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Content $content)
    {
        return view('templates.back.admin.content.show', compact('content'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Content $content)
    {
        $categories = Category::active()->ordered()->get();
        return view('templates.back.admin.content.edit', compact('content', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Content $content)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:contents,slug,' . $content->id,
            'excerpt' => 'nullable|string',
            'content' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'nullable|exists:categories,id',
            'type' => 'required|in:page,article,service,portfolio,other',
            'status' => 'required|in:draft,published,archived',
            'is_featured' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'sort_order' => 'nullable|integer',
        ]);

        $data = $request->all();

        // Generate slug jika tidak ada
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($content->image) {
                Storage::disk('public')->delete($content->image);
            }
            $data['image'] = $request->file('image')->store('contents', 'public');
        }

        // Set published_at jika status berubah ke published
        if ($data['status'] === 'published' && $content->status !== 'published') {
            $data['published_at'] = now();
        }

        $content->update($data);

        return redirect()->route('admin.content.index')
            ->with('success', 'Content berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Content $content)
    {
        // Hapus gambar jika ada
        if ($content->image) {
            Storage::disk('public')->delete($content->image);
        }

        $content->delete();

        return redirect()->route('admin.content.index')
            ->with('success', 'Content berhasil dihapus.');
    }
}
