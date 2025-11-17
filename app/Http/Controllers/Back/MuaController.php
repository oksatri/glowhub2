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
     * Return a flat list of cities (regencies) to be used in MUA forms.
     *
     * The user requested cities limited to the Jabodetabek area and Jawa Timur.
     * Jabodetabek is not a single province in the dataset — it spans several
     * provinces (DKI Jakarta, Banten and parts of Jawa Barat). Here we include
     * regencies whose province name matches a small set: DKI Jakarta, Banten,
     * Jawa Barat (to cover Jabodetabek) and Jawa Timur.
     *
     * Returns an array of arrays: [ ['id' => '...', 'name' => '...'], ... ]
     */
    protected function getLocationData()
    {
        $provinceNames = ['DKI Jakarta', 'Banten', 'Jawa Barat', 'Jawa Timur'];

        $provinceIds = RegProvince::whereIn('name', $provinceNames)->pluck('id')->toArray();

        $cities = RegRegency::whereIn('province_id', $provinceIds)->orderBy('name')->get()->map(function ($r) {
            return ['id' => $r->id, 'name' => $r->name];
        })->values()->toArray();

        // For backward compatibility with views that expect 3 return values,
        // return empty arrays for provinces and districts.
        return [[], $cities, []];
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
        // roles are stored lowercase in DB ('mua')
        // Ambil user dengan role 'mua' yang belum memiliki relasi Mua (satu user hanya satu mua)
        $users = User::where('role', 'mua')
            ->whereDoesntHave('mua')
            ->get();
        // We only need $cities in the form now. Keep provinces/districts for compatibility.
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
            // only city is used now
            'city' => ['nullable', 'string', 'exists:reg_regencies,id'],
            'specialty' => 'nullable|string|max:255',
            'experience' => 'nullable|string|max:255',
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

        $mua = Mua::create(
            collect($data)->only(['user_id', 'name', 'description', 'city', 'specialty', 'experience'])->toArray()
        );

        // Redirect to the appropriate edit path depending on role to avoid
        // hitting admin-only routes when a 'mua' user creates their profile.
        $base = (Auth::check() && Auth::user()->role === 'mua') ? 'muas' : 'admin/muas';
        return redirect(url($base . '/' . $mua->id . '/edit'))->with('success', 'MUA created');
    }

    public function edit($id)
    {
        $mua = Mua::with('services', 'portfolios')->findOrFail($id);
        [$provinces, $cities, $districts] = $this->getLocationData();
        $specialties = Mua::whereNotNull('specialty')->distinct()->orderBy('specialty')->pluck('specialty')->filter()->values()->toArray();
        $users = User::where('role', 'mua')
            ->whereDoesntHave('mua')
            ->get();
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
            'city' => ['nullable', 'string', 'exists:reg_regencies,id'],
            'specialty' => 'nullable|string|max:255',
            'experience' => 'nullable|string|max:255',
            'new_user_name' => 'nullable|string|max:255',
            'new_user_email' => 'nullable|email|max:255|unique:users,email',
            'new_user_password' => 'nullable|string|min:6',
        ]);
        // Only city is considered now; no province/district checks.

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
            collect($data)->only(['user_id', 'name', 'description', 'city', 'specialty', 'experience'])->toArray()
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
        $mua->delete();
        $base = (Auth::check() && Auth::user()->role === 'mua') ? 'muas' : 'admin/muas';
        return redirect(url($base))->with('success', 'MUA removed');
    }
}
