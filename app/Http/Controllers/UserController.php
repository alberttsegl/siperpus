<?php

namespace App\Http\Controllers;

use App\Models\User; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered; 

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        $title = "User Management";
        return view('user.index', compact('users', 'title'));
    }

    public function create()
    {
        $title = "Add New User";
        return view('user.create', compact('title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'role' => 'required|in:admin,guru,siswa,kepala perpustakaan',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ];

        if ($request->hasFile('profile_picture')) {
            $data['profile_picture'] = $request->file('profile_picture')->store('private', 'local');
        }

        $user = User::create($data);
        event(new Registered($user));

        return redirect()->route('user.index')->with('success', 'User created! Silakan cek Gmail untuk verifikasi.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $title = "Edit User";
        return view('user.edit', compact('user', 'title'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'role' => 'required|in:admin,guru,siswa,kepala perpustakaan',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture) {
                Storage::disk('local')->delete($user->profile_picture);
            }
            $user->profile_picture = $request->file('profile_picture')->store('private', 'local');
        }

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('user.index')->with('success', 'User updated successfully');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->profile_picture) {
            Storage::disk('local')->delete($user->profile_picture);
        }
        
        $user->delete();
        return back()->with('success', 'User successfully deleted');
    }

    public function showAvatar($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->profile_picture && Storage::disk('local')->exists($user->profile_picture)) {
            return Storage::disk('local')->response($user->profile_picture);
        }
        
        return redirect("https://ui-avatars.com/api/?name=" . urlencode($user->name) . "&background=random");
    }

    /**
     * Method Baru: Validasi Password Atasan (Admin, Guru, atau Kepala Perpustakaan)
     * Sesuai instruksi tugas untuk Edit/Hapus Purchase
     */
    public function checkBossPassword(Request $request)
    {
        $request->validate([
            'password' => 'required',
        ]);

        // Cari user yang memiliki role atasan (Admin, Guru, atau Kepala Perpustakaan)
        // Kita prioritaskan mengecek apakah ada salah satu user di role tersebut yang passwordnya cocok
        $bosses = User::whereIn('role', ['admin', 'guru', 'kepala perpustakaan'])->get();

        foreach ($bosses as $boss) {
            if (Hash::check($request->password, $boss->password)) {
                return response()->json([
                    'success' => true,
                    'message' => 'Nice! Your password is correct!'
                ], 200);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'Password salah atau Anda tidak memiliki akses!'
        ], 401);
    }
}