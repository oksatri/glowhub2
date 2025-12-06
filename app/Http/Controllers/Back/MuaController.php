<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mua;
use App\Models\MuaService;
use App\Models\MuaPortfolio;
use App\Models\RegProvince;
use App\Models\RegRegency;
use App\Models\RegDistrict;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class MuaController extends Controller
{
    /**
     * Return location data grouped by province_id for backend forms.
     *
     * The user requested cities limited to the Jabodetabek area and Jawa Timur.
     * Jabodetabek spans several provinces (DKI Jakarta, Banten and parts of Jawa Barat).
     * Province names in the Wilayah SQL are uppercase.
     *
     * Returns an array: [ 'provinces' => [...], 'cities' => [...], 'districts' => [...] ]
     * where cities and districts are grouped by their parent province_id / regency_id.
     */
    protected function getLocationData()
    {
        // Province names from Wilayah SQL are uppercase
        $provinceNames = ['DKI JAKARTA', 'BANTEN', 'JAWA BARAT', 'JAWA TIMUR'];

        $provinceIds = RegProvince::whereIn('name', $provinceNames)->pluck('id')->toArray();

        // Group regencies (cities) by province_id
        $cities = RegRegency::whereIn('province_id', $provinceIds)
            ->orderBy('name')
            ->get()
            ->groupBy('province_id')
            ->map(function ($group) {
                return $group->map(function ($r) {
                    return ['id' => $r->id, 'name' => $r->name];
                })->values()->toArray();
            })->toArray();

        // Group districts by regency_id for completeness
        $allRegencyIds = RegRegency::whereIn('province_id', $provinceIds)->pluck('id')->toArray();
        $districts = RegDistrict::whereIn('regency_id', $allRegencyIds)
            ->orderBy('name')
            ->get()
            ->groupBy('regency_id')
            ->map(function ($group) {
                return $group->map(function ($d) {
                    return ['id' => $d->id, 'name' => $d->name];
                })->values()->toArray();
            })->toArray();

        // Return all three for compatibility with views
        return [
            'provinces' => RegProvince::whereIn('id', $provinceIds)->orderBy('name')->get()->map(function ($p) {
                return ['id' => $p->id, 'name' => $p->name];
            })->values()->toArray(),
            'cities' => $cities,
            'districts' => $districts
        ];
    }

    public function index(Request $request)
    {
        $query = Mua::with('user');

        // search query: match name
        if ($q = $request->get('q')) {
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%");
            });
        }

        $muas = $query->orderBy('created_at', 'desc')->paginate(12)->withQueryString();

        return view('back.muas.index', compact('muas'));
    }

    public function create()
    {
        $locationData = $this->getLocationData();
        $provinces = $locationData['provinces'];
        $cities = $locationData['cities'];
        $districts = $locationData['districts'];
        // load users for the linked user dropdown (limit for performance)
        // roles are stored lowercase in DB ('mua')
        // Ambil user dengan role 'mua' yang belum memiliki relasi Mua (satu user hanya satu mua)
        $users = User::where('role', 'mua')
            ->whereDoesntHave('mua')
            ->get();
        // We only need $cities in the form now. Keep provinces/districts for compatibility.
        return view('back.muas.create', compact('provinces', 'cities', 'districts', 'users'));
    }

    public function store(Request $request)
    {
        $locationData = $this->getLocationData();
        $provinces = $locationData['provinces'];
        $cities = $locationData['cities'];
        $districts = $locationData['districts'];

        // If the form uses the sentinel value 'new' for inline user creation,
        // normalize it to null so the "exists:users,id" validation does not
        // try to query the literal string 'new' (Postgres will fail casting).
        if ($request->input('user_id') === 'new') {
            $request->merge(['user_id' => null]);
        }

        $data = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'city' => ['nullable', 'string', 'exists:reg_regencies,id'],
            'service_cities' => 'nullable|array',
            'service_cities.*' => 'required|string|exists:reg_regencies,id',
            'max_distance' => 'nullable|integer|min:0',
            'operational_hours' => 'nullable|string|max:255',
            'additional_charge' => 'nullable|numeric|min:0',
            // optional new user fields (if admin wants to create user inline)
            'new_user_name' => 'nullable|string|max:255',
            'new_user_email' => 'nullable|email|max:255|unique:users,email',
            'new_user_username' => 'nullable|string|max:255|unique:users,username',
            'new_user_password' => 'nullable|string|min:6',
        ]);

        // No province/district validation needed anymore — only city is used.

        // handle inline user creation: admin can create a linked user from the form
        if (empty($data['user_id']) && !empty($data['new_user_email'])) {
            // require name and password as well
            if (empty($data['new_user_name']) || empty($data['new_user_password'])) {
                return back()->withInput()->withErrors(['new_user_name' => 'Name and password are required when creating a new user inline.']);
            }
            // ensure username is set (DB migration requires non-null unique username)
            $username = $data['new_user_username'] ?? null;
            if (empty($username)) {
                $local = explode('@', $data['new_user_email'])[0] ?? 'user';
                // sanitize and fallback
                $base = preg_replace('/[^a-z0-9_]/i', '', strtolower($local)) ?: 'user';
                $username = $base;
                $i = 1;
                while (User::where('username', $username)->exists()) {
                    $username = $base . $i;
                    $i++;
                }
            }

            $user = User::create([
                'name' => $data['new_user_name'],
                'username' => $username,
                'email' => $data['new_user_email'],
                'password' => Hash::make($data['new_user_password']),
                'role' => 'mua',
            ]);
            $data['user_id'] = $user->id;
        }

        // auto-assign user_id if not provided
        if (empty($data['user_id']) && Auth::check()) {
            $data['user_id'] = Auth::id();
        }

        // Handle multiple service cities - convert array to comma-separated string
        if (isset($data['service_cities']) && is_array($data['service_cities'])) {
            $data['service_cities'] = implode(',', $data['service_cities']);
        }

        $mua = Mua::create(
            collect($data)->only([
                'user_id',
                'name',
                'description',
                'city',
                'service_cities',
                'max_distance',
                'operational_hours',
                'additional_charge',
            ])->toArray()
        );

        // Redirect to the appropriate edit path depending on role to avoid
        // hitting admin-only routes when a 'mua' user creates their profile.
        $base = (Auth::check() && Auth::user()->role === 'mua') ? 'muas' : 'admin/muas';
        return redirect(url($base . '/' . $mua->id . '/edit'))->with('success', 'MUA created');
    }

    public function edit($id)
    {
        $mua = Mua::with('services', 'portfolios')->findOrFail($id);
        // Convert service cities string to array for the form
        if ($mua->service_cities && !is_array($mua->service_cities)) {
            $mua->service_cities = explode(',', $mua->service_cities);
        }
        
        $locationData = $this->getLocationData();
        $provinces = $locationData['provinces'];
        $cities = $locationData['cities'];
        $districts = $locationData['districts'];
        $users = User::where('role', 'mua')
            ->whereDoesntHave('mua')
            ->get();
        return view('back.muas.edit', compact('mua', 'provinces', 'cities', 'districts', 'users'));
    }

    public function update(Request $request, $id)
    {
        $mua = Mua::findOrFail($id);
        $locationData = $this->getLocationData();
        $provinces = $locationData['provinces'];
        $cities = $locationData['cities'];
        $districts = $locationData['districts'];

        // Normalize 'new' sentinel like in store() so validation won't query 'new'.
        // if ($request->input('user_id') === 'new') {
        //     $request->merge(['user_id' => null]);
        // }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'city' => ['nullable', 'string', 'exists:reg_regencies,id'],
            'service_cities' => 'nullable|array',
            'service_cities.*' => 'required|string|exists:reg_regencies,id',
            'max_distance' => 'nullable|integer|min:0',
            'operational_hours' => 'nullable|string|max:255',
            'additional_charge' => 'nullable|numeric|min:0',
            'availability_hours' => 'nullable|array',
            'availability_hours.*.date' => 'required|date',
            'availability_hours.*.start_time' => 'required|string',
            'availability_hours.*.end_time' => 'required|string',
            'availability_hours.*.reason' => 'nullable|string',
            'link_map' => 'nullable|string|max:255',
        ]);
        // Only city is considered now; no province/district checks.

        // handle inline new user creation on update
        // if (empty($data['user_id']) && !empty($data['new_user_email'])) {
        //     if (empty($data['new_user_name']) || empty($data['new_user_password'])) {
        //         return back()->withInput()->withErrors(['new_user_name' => 'Name and password are required when creating a new user inline.']);
        //     }
        //     // ensure username is set
        //     $username = $data['new_user_username'] ?? null;
        //     if (empty($username)) {
        //         $local = explode('@', $data['new_user_email'])[0] ?? 'user';
        //         $base = preg_replace('/[^a-z0-9_]/i', '', strtolower($local)) ?: 'user';
        //         $username = $base;
        //         $i = 1;
        //         while (User::where('username', $username)->exists()) {
        //             $username = $base . $i;
        //             $i++;
        //         }
        //     }

        //     $user = User::create([
        //         'name' => $data['new_user_name'],
        //         'username' => $username,
        //         'email' => $data['new_user_email'],
        //         'password' => Hash::make($data['new_user_password']),
        //         'role' => 'mua',
        //     ]);
        //     $data['user_id'] = $user->id;
        // }

        // Handle multiple service cities - convert array to comma-separated string
        if (isset($data['service_cities']) && is_array($data['service_cities'])) {
            $data['service_cities'] = implode(',', $data['service_cities']);
        }

        $mua->update(
            collect($data)->only([
                'name',
                'description',
                'city',
                'service_cities',
                'max_distance',
                'operational_hours',
                'additional_charge',
                'availability_hours',
                'link_map',
            ])->toArray()
        );

        $base = (Auth::check() && Auth::user()->role === 'mua') ? 'muas' : 'admin/muas';
        return redirect(url($base . '/' . $mua->id . '/edit'))->with('success', 'MUA updated');
    }

    public function show($id)
    {
        $mua = Mua::with('services', 'portfolios')->findOrFail($id);
        return view('back.muas.show', compact('mua'));
    }

    public function destroy($id)
    {
        $mua = Mua::findOrFail($id);
        // delete images
        if ($mua->image) {
            Storage::disk('public')->delete($mua->image);
        }
        // delete portfolios files
        foreach ($mua->portfolios as $p) {
            if ($p->image) Storage::disk('public')->delete($p->image);
        }
        if ($mua->user) {
            $mua->user()->delete();
        }
        $mua->delete();
        $base = (Auth::check() && Auth::user()->role === 'mua') ? 'muas' : 'admin/muas';
        return redirect(url($base))->with('success', 'MUA removed');
    }
}
