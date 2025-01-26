<?php

namespace App\Http\Controllers;
use App\Models\User;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index($userId)
    {
        return view('admin.fitur_kelolaakun', [
            'users' => User::all(),
            'userId' => $userId
        ]);
    }

    public function destroy($id)
    {
        $user = User::find($id);

        if ($user) {
            // Perform the deletion
            $user->delete();

            // Return a JSON response for the frontend to handle
            return response()->json(['success' => true, 'message' => 'Pengguna berhasil dihapus.']);
        }

        // If the user is not found, return a JSON error response
        return response()->json(['success' => false, 'message' => 'Pengguna tidak ditemukan.'], 404);
    }




}
