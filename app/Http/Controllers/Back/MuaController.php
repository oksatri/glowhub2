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
     * Return arrays of provinces and cities grouped by province.
     * In a real app this would come from a DB or external service.
     */
    protected function getLocationData()
    {
        // Load provinces keyed by id => name
        $provinces = RegProvince::orderBy('name')->pluck('name', 'id')->toArray();

        // Group regencies by province_id; each regency is an array of {id,name}
        $cities = RegRegency::orderBy('name')->get()->groupBy('province_id')->map(function ($group) {
            return $group->map(function ($r) {
                return ['id' => $r->id, 'name' => $r->name];
            })->values()->toArray();
        })->toArray();

        // Group districts by regency_id; each district is an array of {id,name}
        $districts = RegDistrict::orderBy('name')->get()->groupBy('regency_id')->map(function ($group) {
            return $group->map(function ($d) {
                return ['id' => $d->id, 'name' => $d->name];
            })->values()->toArray();
        })->toArray();

        return [$provinces, $cities, $districts];
    }

    public function index(Request $request)
    {
        $query = Mua::with('user');

        // search query: match name or specialty
        if ($q = $request->get('q')) {
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('specialty', 'like', "%{$q}%");
            });
        }

        // specialty filter (exact match)
        if ($specialty = $request->get('specialty')) {
            $query->where('specialty', $specialty);
        }

        $muas = $query->orderBy('created_at', 'desc')->paginate(12)->withQueryString();

        return view('back.muas.index', compact('muas'));
    }

    public function create()
    {
        [$provinces, $cities, $districts] = $this->getLocationData();
        // provide existing specialties for datalist
        $specialties = Mua::whereNotNull('specialty')->distinct()->orderBy('specialty')->pluck('specialty')->filter()->values()->toArray();
        // load users for the linked user dropdown (limit for performance)
        $users = User::where('role', 'MUA')->limit(50)->get();
        return view('back.muas.create', compact('provinces', 'cities', 'districts', 'specialties', 'users'));
    }

    public function store(Request $request)
    {
        [$provinces, $cities, $districts] = $this->getLocationData();

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
            'province' => ['nullable', Rule::in(array_keys($provinces))],
            // regency/district ids are strings in wilayah tables (keyType = string)
            'city' => ['nullable', 'string', 'exists:reg_regencies,id'],
            'district' => ['nullable', 'string', 'exists:reg_districts,id'],
            'specialty' => 'nullable|string|max:255',
            'experience' => 'nullable|string|max:255',
            // optional new user fields (if admin wants to create user inline)
            'new_user_name' => 'nullable|string|max:255',
            'new_user_email' => 'nullable|email|max:255|unique:users,email',
            'new_user_username' => 'nullable|string|max:255|unique:users,username',
            'new_user_password' => 'nullable|string|min:6',
        ]);

        // validate city value if province provided (ensure regency belongs to province)
        if (!empty($data['province']) && !empty($data['city'])) {
            $exists = RegRegency::where('id', $data['city'])->where('province_id', $data['province'])->exists();
            if (!$exists) {
                return back()->withInput()->withErrors(['city' => 'Selected city is invalid for the chosen province.']);
            }
        }

        // validate district if city provided (ensure district belongs to regency)
        if (!empty($data['city']) && !empty($data['district'])) {
            $exists = RegDistrict::where('id', $data['district'])->where('regency_id', $data['city'])->exists();
            if (!$exists) {
                return back()->withInput()->withErrors(['district' => 'Selected district is invalid for the chosen city.']);
            }
        }

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

        $mua = Mua::create(
            collect($data)->only(['user_id', 'name', 'description', 'province', 'city', 'district', 'specialty', 'experience'])->toArray()
        );

        return redirect(url('muas/' . $mua->id . '/edit'))->with('success', 'MUA created');
    }

    public function edit($id)
    {
        $mua = Mua::with('services', 'portfolios')->findOrFail($id);
        [$provinces, $cities, $districts] = $this->getLocationData();
        $specialties = Mua::whereNotNull('specialty')->distinct()->orderBy('specialty')->pluck('specialty')->filter()->values()->toArray();
        $users = User::where('role', 'MUA')->limit(50)->get();
        return view('back.muas.edit', compact('mua', 'provinces', 'cities', 'districts', 'specialties', 'users'));
    }

    public function update(Request $request, $id)
    {
        $mua = Mua::findOrFail($id);
        [$provinces, $cities, $districts] = $this->getLocationData();

        // Normalize 'new' sentinel like in store() so validation won't query 'new'.
        if ($request->input('user_id') === 'new') {
            $request->merge(['user_id' => null]);
        }

        $data = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'province' => ['nullable', Rule::in(array_keys($provinces))],
            'city' => ['nullable', 'string', 'exists:reg_regencies,id'],
            'district' => ['nullable', 'string', 'exists:reg_districts,id'],
            'specialty' => 'nullable|string|max:255',
            'experience' => 'nullable|string|max:255',
            'new_user_name' => 'nullable|string|max:255',
            'new_user_email' => 'nullable|email|max:255|unique:users,email',
            'new_user_password' => 'nullable|string|min:6',
        ]);

        if (!empty($data['province']) && !empty($data['city'])) {
            // $cities is grouped as [province_id => [ ['id'=>..., 'name'=>...], ... ]]
            // extract the id column for proper comparison with the scalar city id
            $allowedCities = array_column($cities[$data['province']] ?? [], 'id');
            if (!in_array($data['city'], $allowedCities)) {
                return back()->withInput()->withErrors(['city' => 'Selected city is invalid for the chosen province.']);
            }
        }

        // validate district if city provided
        if (!empty($data['city']) && !empty($data['district'])) {
            // $districts is grouped as [regency_id => [ ['id'=>..., 'name'=>...], ... ]]
            $allowedDistricts = array_column($districts[$data['city']] ?? [], 'id');
            if (!in_array($data['district'], $allowedDistricts)) {
                return back()->withInput()->withErrors(['district' => 'Selected district is invalid for the chosen city.']);
            }
        }

        // handle inline new user creation on update
        if (empty($data['user_id']) && !empty($data['new_user_email'])) {
            if (empty($data['new_user_name']) || empty($data['new_user_password'])) {
                return back()->withInput()->withErrors(['new_user_name' => 'Name and password are required when creating a new user inline.']);
            }
            // ensure username is set
            $username = $data['new_user_username'] ?? null;
            if (empty($username)) {
                $local = explode('@', $data['new_user_email'])[0] ?? 'user';
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

        $mua->update(
            collect($data)->only(['user_id', 'name', 'description', 'province', 'city', 'district', 'specialty', 'experience'])->toArray()
        );

        return redirect(url('muas/' . $mua->id . '/edit'))->with('success', 'MUA updated');
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
        $mua->delete();
        return redirect(url('muas'))->with('success', 'MUA removed');
    }
}
