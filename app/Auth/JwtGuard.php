<?php

namespace App\Auth;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use Illuminate\Contracts\Auth\UserProvider;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth as AuthFacade;

class JwtGuard implements Guard
{
    protected ?UserContract $user = null;
    protected UserProvider $provider;

    public function __construct(UserProvider $provider)
    {
        $this->provider = $provider;
    }

    public function user(): ?UserContract
    {
        // Always resolve user from current request/guards (don't cache across requests)

        $req = request();
        // Try common places for bearer token. Some servers (Apache/mod_php)
        // do not forward the `Authorization` header to PHP by default, so
        // accept alternative locations: `X-Api-Token` header or `token`
        // query/body parameter.
        $header = $req->header('Authorization', '') ?: $req->bearerToken();
        $token = null;
        if ($header && str_starts_with($header, 'Bearer ')) {
            $token = substr($header, 7);
        } elseif ($header) {
            $token = $header;
        }

        // Fallbacks if Authorization header wasn't forwarded
        if (!$token) {
            $token = $req->header('X-Api-Token') ?: $req->query('token') ?: $req->input('token');
        }

        $userId = JWTAuth::getUserIdFromToken($token);
        if ($userId) {
            $this->user = $this->provider->retrieveById($userId);
            return $this->user;
        }

        // Fallback: if Sanctum (or other guard) has an authenticated user during tests
        if (AuthFacade::guard('sanctum')->check()) {
            $this->user = AuthFacade::guard('sanctum')->user();
            return $this->user;
        }

        return $this->user;
    }

    public function id()
    {
        return $this->user()?->getAuthIdentifier();
    }

    public function validate(array $credentials = []): bool
    {
        return false;
    }

    public function setUser(UserContract $user)
    {
        $this->user = $user;
        return $this;
    }

    public function check(): bool
    {
        return $this->user() !== null;
    }

    public function guest(): bool
    {
        return !$this->check();
    }

    public function hasUser(): bool
    {
        return $this->user !== null;
    }
}
