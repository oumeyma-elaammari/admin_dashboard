<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        try {
            $users = User::select('id', 'name', 'email', 'role', 'created_at')->get();
            return response()->json(['success' => true, 'data' => $users]);
        } catch (\Throwable $e) {
            \Log::error('Erreur liste utilisateurs: '.$e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erreur interne, impossible de récupérer les utilisateurs.'
            ], 500);
        }
    }

  public function store(Request $request)
{
    \Log::info('UserController@store called', ['payload' => $request->all(), 'user_id' => optional($request->user())->id]);

    try {
        $request->validate([
            'name'     => 'required|string',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'subadmin'
        ]);

        return response()->json([
            'message' => 'Sous-admin créé avec succès',
            'user'    => $user
        ], 201);
    } catch (\Throwable $e) {
        \Log::error('Erreur création sous-admin: '.$e->getMessage(), ['trace' => $e->getTraceAsString()]);
        return response()->json([
            'message' => 'Erreur interne serveur',
            'detail' => $e->getMessage()
        ], 500);
    }
}


    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);

            if ($user->role === 'admin') {
                return response()->json(['success' => false, 'message' => 'Vous ne pouvez pas supprimer l\'administrateur principal'], 403);
            }

            $user->delete();
            return response()->json(['success' => true, 'message' => 'Utilisateur supprimé avec succès']);
        } catch (\Throwable $e) {
            \Log::error('Erreur suppression utilisateur: '.$e->getMessage());
            return response()->json(['success' => false, 'message' => 'Erreur lors de la suppression'], 500);
        }
    }

    public function clients()
    {
        try {
            $clients = User::where('role', 'client')->get();
            return response()->json(['success' => true, 'data' => $clients]);
        } catch (\Throwable $e) {
            \Log::error('Erreur récupération clients: '.$e->getMessage());
            return response()->json(['success' => false, 'message' => 'Erreur interne'], 500);
        }
    }
}
