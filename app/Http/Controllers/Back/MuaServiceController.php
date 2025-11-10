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
            'fitur' => 'nullable',
            'harga' => 'nullable|numeric'
        ]);

        $payload = [
            'mua_id' => $mua->id,
            'service_name' => $data['nama_service'],
            'description' => $data['deskripsi'] ?? null,
            'price' => isset($data['harga']) && $data['harga'] !== '' ? (int) $data['harga'] : 0,
        ];

        // fitur bisa berupa array atau string, simpan ke db sebagai JSON
        if (!empty($data['fitur'])) {
            if (is_array($data['fitur'])) {
                $payload['features'] = json_encode($data['fitur']);
            } else {
                $decoded = json_decode($data['fitur'], true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    $payload['features'] = json_encode($decoded);
                } else {
                    $payload['features'] = json_encode(array_values(array_filter(array_map('trim', explode(',', $data['fitur'])))));
                }
            }
        } else {
            $payload['features'] = null;
        }

        MuaService::create($payload);

        return redirect(url('muas/' . $mua->id . '/edit'))->with('success', 'Service added');
    }

    public function destroy($muaId, $id)
    {
        $service = MuaService::where('mua_id', $muaId)->findOrFail($id);
        $service->delete();
        return redirect(url('muas/' . $muaId . '/edit'))->with('success', 'Service removed');
    }
}
