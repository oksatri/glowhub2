<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HowItWork;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HowItWorkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $howItWorks = HowItWork::orderBy('step_number')->paginate(10);
        return view('templates.back.admin.how-it-works.index', compact('howItWorks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('templates.back.admin.how-it-works.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'step_number' => 'required|integer|min:1',
            'icon' => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('how-it-works', 'public');
        }

        HowItWork::create($data);

        return redirect()->route('admin.how-it-works.index')
            ->with('success', 'How it works step created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(HowItWork $howItWork)
    {
        return view('templates.back.admin.how-it-works.show', compact('howItWork'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HowItWork $howItWork)
    {
        return view('templates.back.admin.how-it-works.edit', compact('howItWork'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HowItWork $howItWork)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'step_number' => 'required|integer|min:1',
            'icon' => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($howItWork->image) {
                Storage::disk('public')->delete($howItWork->image);
            }
            $data['image'] = $request->file('image')->store('how-it-works', 'public');
        }

        $howItWork->update($data);

        return redirect()->route('admin.how-it-works.index')
            ->with('success', 'How it works step updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HowItWork $howItWork)
    {
        if ($howItWork->image) {
            Storage::disk('public')->delete($howItWork->image);
        }

        $howItWork->delete();

        return redirect()->route('admin.how-it-works.index')
            ->with('success', 'How it works step deleted successfully.');
    }
}
