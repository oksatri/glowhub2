<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::orderBy('order')->paginate(20);
        return view('back.testimonials.index', compact('testimonials'));
    }

    public function create()
    {
        return view('back.testimonials.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:191',
            'role' => 'nullable|string|max:191',
            'rating' => 'nullable|integer|min:1|max:5',
            'quote' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'status' => 'required|in:publish,draft,archive',
            'order' => 'nullable|integer',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('testimonials', 'public');
        }

        Testimonial::create($data + ['rating' => $data['rating'] ?? 5]);

        return redirect(url('testimonials'))->with('success', 'Testimonial created.');
    }

    public function edit($id)
    {
        $t = Testimonial::findOrFail($id);
        return view('back.testimonials.edit', compact('t'));
    }

    public function update(Request $request, $id)
    {
        $t = Testimonial::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:191',
            'role' => 'nullable|string|max:191',
            'rating' => 'nullable|integer|min:1|max:5',
            'quote' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'status' => 'required|in:publish,draft,archive',
            'order' => 'nullable|integer',
        ]);

        if ($request->hasFile('image')) {
            if ($t->image && Storage::disk('public')->exists($t->image)) {
                Storage::disk('public')->delete($t->image);
            }
            $data['image'] = $request->file('image')->store('testimonials', 'public');
        }

        $t->update($data + ['rating' => $data['rating'] ?? $t->rating]);

        return redirect(url('testimonials'))->with('success', 'Testimonial updated.');
    }

    public function destroy($id)
    {
        $t = Testimonial::findOrFail($id);
        if ($t->image && Storage::disk('public')->exists($t->image)) {
            Storage::disk('public')->delete($t->image);
        }
        $t->delete();
        return back()->with('success', 'Testimonial deleted.');
    }
}
