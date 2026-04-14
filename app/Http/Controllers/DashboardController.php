<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role;

        // Arahkan ke file blade yang berbeda berdasarkan role
        if ($role === 'admin') {
            return view('admin.dashboard', ['title' => 'Admin Dashboard']);
        } elseif ($role === 'guru') {
            return view('guru.dashboard', ['title' => 'Guru Dashboard']);
        } else {
            return view('siswa.dashboard', ['title' => 'Siswa Dashboard']);
        }
    }
}