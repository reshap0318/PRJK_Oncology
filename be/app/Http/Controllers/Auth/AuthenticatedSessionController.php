<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Responses\Success;
use Illuminate\Http\{
    Request,
    JsonResponse
};
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): JsonResponse
    {
        $resp = $request->authenticate();
        return Success::defaultSuccessWithData($resp)->withCookie(cookie("Authorization", $resp['token']['access_token']));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): JsonResponse
    {
        Auth::guard('api')->logout(true);
        return Success::defaultSuccessExtraMessage("Logout");
    }
}
