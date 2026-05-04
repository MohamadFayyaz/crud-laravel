<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('hobbies')->latest()->paginate(10);
        return response()->json(['status' => 'success', 'data' => $users]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'phone'    => 'nullable|string',
            'address'  => 'nullable|string',
            'hobbies'  => 'nullable|array',
            'hobbies.*' => 'string|max:100',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'phone'    => $request->phone,
            'address'  => $request->address,
        ]);

        // Simpan hobi
        if ($request->hobbies) {
            foreach ($request->hobbies as $hobby) {
                $user->hobbies()->create(['name' => $hobby]);
            }
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'User berhasil dibuat',
            'data'    => $user->load('hobbies'),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::with('hobbies')->find($id);

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'User tidak ditemukan'], 404);
        }

        return response()->json(['status' => 'success', 'data' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'User tidak ditemukan'], 404);
        }

        $request->validate([
            'name'     => 'sometimes|string|max:255',
            'email'    => 'sometimes|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6',
            'phone'    => 'nullable|string',
            'address'  => 'nullable|string',
            'hobbies'  => 'nullable|array',
            'hobbies.*' => 'string|max:100',
        ]);

        $user->update([
            'name'     => $request->name ?? $user->name,
            'email'    => $request->email ?? $user->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
            'phone'    => $request->phone ?? $user->phone,
            'address'  => $request->address ?? $user->address,
        ]);

        // Update hobi: hapus lama, tambah baru
        if ($request->has('hobbies')) {
            $user->hobbies()->delete();
            foreach ($request->hobbies as $hobby) {
                $user->hobbies()->create(['name' => $hobby]);
            }
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'User berhasil diperbarui',
            'data'    => $user->load('hobbies'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'User tidak ditemukan'], 404);
        }

        // Hobi terhapus otomatis karena onDelete('cascade')
        $user->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'User berhasil dihapus',
        ]);
    }
}
