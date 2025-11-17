<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mua;
use App\Models\MuaPortfolio;
use Illuminate\Support\Facades\Storage;

class MuaPortfolioController extends Controller
{
    public function store(Request $request, $muaId)
    {
        $mua = Mua::findOrFail($muaId);

        $data = $request->validate([
            // allow multiple images upload via images[] or single image via image
            'images' => 'nullable|array',
            'images.*' => 'image|max:4096',
            'image' => 'nullable|image|max:4096',
            'description' => 'nullable|string',
            // require a service to be selected — portfolio must be attached to a service
            'mua_service_id' => 'required|exists:mua_services,id'
        ]);

        // ensure the selected service belongs to this MUA
        $service = \App\Models\MuaService::find($data['mua_service_id']);
        if (!$service || $service->mua_id != $mua->id) {
            return back()->withInput()->withErrors(['mua_service_id' => 'Selected service is invalid for this MUA.']);
        }

        $created = 0;
        // handle multiple images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $path = $img->store('mua_portfolios', 'public');
                MuaPortfolio::create([
                    'mua_id' => $mua->id,
                    'image' => $path,
                    'description' => $data['description'] ?? null,
                    'mua_service_id' => $data['mua_service_id'],
                ]);
                $created++;
            }
        } elseif ($request->hasFile('image')) {
            $path = $request->file('image')->store('mua_portfolios', 'public');
            MuaPortfolio::create([
                'mua_id' => $mua->id,
                'image' => $path,
                'description' => $data['description'] ?? null,
                'mua_service_id' => $data['mua_service_id'],
            ]);
            $created++;
        }

    $base = (auth()->check() && auth()->user()->role === 'admin') ? 'admin/muas' : 'muas';
    return redirect(url($base . '/' . $mua->id . '/edit'))->with('success', 'Portfolio uploaded');
    }

    public function destroy($muaId, $id)
    {
        $p = MuaPortfolio::where('mua_id', $muaId)->findOrFail($id);
        if ($p->image) Storage::disk('public')->delete($p->image);
        $p->delete();
    $base = (auth()->check() && auth()->user()->role === 'admin') ? 'admin/muas' : 'muas';
    return redirect(url($base . '/' . $muaId . '/edit'))->with('success', 'Portfolio removed');
    }
}
