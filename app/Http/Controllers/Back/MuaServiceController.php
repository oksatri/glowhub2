<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mua;
use App\Models\MuaService;

class MuaServiceController extends Controller
{
    public function store(Request $request, $muaId)
    {
        $mua = Mua::findOrFail($muaId);

        $data = $request->validate([
            'nama_service' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'features' => 'nullable',
            'harga' => 'nullable|numeric',
            'categori_service' => 'nullable|array',
        ]);

        $payload = [
            'mua_id' => $mua->id,
            'service_name' => $data['nama_service'],
            'description' => $data['deskripsi'] ?? null,
            'price' => isset($data['harga']) && $data['harga'] !== '' ? (int) $data['harga'] : 0,
        ];

        // map selected occasions into a single string (e.g. "Akad,Wedding (Resepsi)")
        if (!empty($data['categori_service']) && is_array($data['categori_service'])) {
            $payload['categori_service'] = implode(',', $data['categori_service']);
        }

        // features bisa berupa array atau string, simpan ke db sebagai JSON
        if (!empty($data['features'])) {
            if (is_array($data['features'])) {
                $payload['features'] = json_encode($data['features']);
            } else {
                $decoded = json_decode($data['features'], true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    $payload['features'] = json_encode($decoded);
                } else {
                    $payload['features'] = json_encode(array_values(array_filter(array_map('trim', explode(',', $data['features'])))));
                }
            }
        } else {
            $payload['features'] = null;
        }

        MuaService::create($payload);

    $base = (auth()->check() && auth()->user()->role === 'admin') ? 'admin/muas' : 'muas';
    return redirect(url($base . '/' . $mua->id . '/edit'))->with('success', 'Service added');
    }

    public function update(Request $request, $muaId, $id)
    {
        $mua = Mua::findOrFail($muaId);

        $service = MuaService::where('mua_id', $mua->id)->findOrFail($id);

        $data = $request->validate([
            'nama_service' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'features' => 'nullable',
            'harga' => 'nullable|numeric',
            'categori_service' => 'nullable|array',
        ]);

        $payload = [
            'service_name' => $data['nama_service'],
            'description' => $data['deskripsi'] ?? null,
            'price' => isset($data['harga']) && $data['harga'] !== '' ? (int) $data['harga'] : 0,
        ];

        if (!empty($data['categori_service']) && is_array($data['categori_service'])) {
            $payload['categori_service'] = implode(',', $data['categori_service']);
        } else {
            $payload['categori_service'] = null;
        }

        if (!empty($data['features'])) {
            if (is_array($data['features'])) {
                $payload['features'] = json_encode($data['features']);
            } else {
                $decoded = json_decode($data['features'], true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    $payload['features'] = json_encode($decoded);
                } else {
                    $payload['features'] = json_encode(array_values(array_filter(array_map('trim', explode(',', $data['features'])))));
                }
            }
        } else {
            $payload['features'] = null;
        }

        $service->update($payload);

    $base = (auth()->check() && auth()->user()->role === 'admin') ? 'admin/muas' : 'muas';
    return redirect(url($base . '/' . $mua->id . '/edit'))->with('success', 'Service updated');
    }

    public function destroy($muaId, $id)
    {
        $service = MuaService::where('mua_id', $muaId)->findOrFail($id);
        $service->delete();
    $base = (auth()->check() && auth()->user()->role === 'admin') ? 'admin/muas' : 'muas';
    return redirect(url($base . '/' . $muaId . '/edit'))->with('success', 'Service removed');
    }
}
