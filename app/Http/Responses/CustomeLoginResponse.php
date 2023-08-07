<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse;
use Illuminate\Http\RedirectResponse;

class CustomLoginResponse implements LoginResponse
{
    public function toResponse($request)
    {
        dd('masuk22');
        return $request->wantsJson()
            ? response()->json(['message' => 'Login successful'], 200)
            : new RedirectResponse(route('home')); // Replace 'home' with the route name of your homepage
    }
}