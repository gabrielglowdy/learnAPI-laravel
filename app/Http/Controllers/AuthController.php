<?php

namespace App\Http\Controllers;

use App\Transformers\UserTransformer;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $this->validate(
            $request,
            [
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:8'
            ]
        );

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'api_token' => Hash::make($request->email . $request->password)
        ]);
        $response = fractal()
            ->item($user)
            ->transformWith(new UserTransformer)
            ->addMeta(['token' => $user->api_token])
            ->toArray();

        return response()->json($response, 201);
    }

    public function login(Request $request)
    {
        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json(['error' => 'Your credential is wrong'], 401);
        }

        $user = User::find(Auth::user()->id);

        return fractal()
            ->item($user)
            ->transformWith(new UserTransformer)
            ->addMeta(['token' => $user->api_token])
            ->toArray();
    }

    public function profile()
    {
        $user = User::find(Auth::user()->id);

        return fractal()
        ->item($user)
        ->transformWith(new UserTransformer)
        ->includePosts()
        ->toArray();
    }
}
