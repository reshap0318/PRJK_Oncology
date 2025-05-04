<?php

namespace App\Http\Requests\Auth;

use App\Helpers\Authorization;
use App\Models\User;
use App\Repository\Module\AnggotaRepository;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    protected $loginField;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    public function attributes(): array
    {
        return [
            'login'     => 'username / email',
        ];
    }

    public function prepareForValidation()
    {
        $loginField = filter_var($this->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $loginValue = $this->login;
        $this->loginField = $loginField;
        $this->merge([$loginField => $loginValue]);
    }

    public function authenticate(): array
    {
        $this->ensureIsNotRateLimited();
        $payload = [
            $this->loginField     => $this->login,
            'password'            => $this->password
        ];
        if (!$token = Auth::attempt($payload)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'login' => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
        $user = User::find(Auth::id());
        if ($user->is_active == User::S_NON_ACTIVE) {
            Auth::logout();
            throw ValidationException::withMessages([
                'login' => 'akun anda tidak aktif',
            ]);
            return [];
        }

        $user->update(['last_login' => now()]);

        //set config application
        $permissions = Authorization::getUserAkses();
        return [
            'user'  => [
                'id'        => $user->id,
                'username'  => $user->username,
                'name'      => $user->name,
                'email'     => $user->email,
                'avatar_url' => $user->avatar_url,
            ],
            'token' => [
                'access_token' => $token,
                'expires_in'   => Auth::factory()->getTTL() * 60,
            ],
            'permissions' => $permissions,
        ];
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->input('email')) . '|' . $this->ip());
    }
}
