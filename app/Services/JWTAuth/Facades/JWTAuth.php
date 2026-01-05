<?php

namespace PHPOpenSourceSaver\JWTAuth\Facades;

use App\Models\User;

class JWTAuth
{
    /** Simple in-memory token map for tests. */
    protected static array $tokens = [];

    public static function fromUser(User $user): string
    {
        $token = base64_encode(uniqid('token_', true) . '|' . $user->id);
        self::$tokens[$token] = ['user_id' => $user->id, 'created_at' => time()];
        return $token;
    }

    public static function factory()
    {
        return new class {
            public function getTTL()
            {
                return 60; // minutes
            }
        };
    }

    public static function parseToken()
    {
        return new class {
            public function invalidate()
            {
                // No-op for tests (tokens stored in memory only)
                return true;
            }
        };
    }

    /** Helper used by our JwtGuard to resolve token -> user_id */
    public static function getUserIdFromToken(?string $token): ?int
    {
        if (!$token) {
            return null;
        }
        return self::$tokens[$token]['user_id'] ?? null;
    }

    public static function revokeToken(?string $token): void
    {
        if ($token && isset(self::$tokens[$token])) {
            unset(self::$tokens[$token]);
        }
    }
}
