<?php

namespace App\Http\Controllers;

use App\Models\User; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validasi foto
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ];

        // Simpan ke storage/app/private
        if ($request->hasFile('profile_picture')) {
            $data['profile_picture'] = $request->file('profile_picture')->store('private', 'local');
        }

        User::create($data);

        return redirect()->route('user.index')->with('success', 'User created successfully');
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
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        // Update foto jika ada file baru
        if ($request->hasFile('profile_picture')) {
            // Hapus foto lama jika ada
            if ($user->profile_picture) {
                Storage::disk('local')->delete($user->profile_picture);
            }
            // Simpan foto baru ke private
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
        
        // Hapus file fisik dari storage sebelum hapus data di DB
        if ($user->profile_picture) {
            Storage::disk('local')->delete($user->profile_picture);
        }
        
        $user->delete();
        return back()->with('success', 'User successfully deleted');
    }

    /**
     * Menampilkan Avatar berdasarkan ID (untuk tabel dan edit)
     */
    public function showAvatar($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->profile_picture && Storage::disk('local')->exists($user->profile_picture)) {
            return Storage::disk('local')->response($user->profile_picture);
        }
        
        // Fallback jika tidak ada foto
        return redirect("https://ui-avatars.com/api/?name=" . urlencode($user->name) . "&background=random");
    }
}