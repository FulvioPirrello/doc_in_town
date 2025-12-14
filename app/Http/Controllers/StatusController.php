<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class StatusController extends Controller
{
    public function controlla_status()
    {
        if (!Auth::check()) 
        {
            return response()->json(['logged_in' => false], 200);
        }

        $user = Auth::user();

        return response()->json([
            'logged_in' => true,
            'user' => 
                    [
                     'id' => $user->id,
                     'username' => $user->name,
                    ],
        ], 200);
    }
}
