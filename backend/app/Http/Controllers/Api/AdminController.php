<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;

class AdminController extends Controller
{
    public function index()
    {
        return Admin::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:admins',
            'password' => 'required|min:6'
        ]);

        // Simpan password terenkripsi
        $validated['password'] = bcrypt($validated['password']);
        return Admin::create($validated);
    }

    public function show(Admin $admin)
    {
        return $admin;
    }

    public function update(Request $request, Admin $admin)
    {
        if ($request->has('password')) {
            $request->merge(['password' => bcrypt($request->password)]);
        }
        $admin->update($request->all());
        return $admin;
    }

    public function destroy(Admin $admin)
    {
        $admin->delete();
        return response()->noContent();
    }
}
