<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role;

        // Admin, Guru, dan Kepala Perpustakaan diarahkan ke view yang sama 
        // supaya sidebar di 'admin.dashboard' (yang memuat menu.blade.php) muncul lengkap
        if ($role === 'admin' || $role === 'kepala perpustakaan' || $role === 'guru') {
            return view('admin.dashboard', ['title' => 'Management Dashboard']);
        } else {
            // Siswa tetap menggunakan dashboard khusus siswa
            return view('siswa.dashboard', ['title' => 'Siswa Dashboard']);
        }
    }
}