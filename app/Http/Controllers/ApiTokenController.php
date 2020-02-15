<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;

class ApiTokenController extends Controller
{
    public function update(User $user)
    {
        $token = Str::random(60);
        $user->api_token = $token;

        $user->save();

        return $token;
    }
}
