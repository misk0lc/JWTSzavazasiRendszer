<?php

namespace PHPOpenSourceSaver\JWTAuth\Contracts;

interface JWTSubject
{
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     */
    public function getJWTIdentifier();

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     */
    public function getJWTCustomClaims(): array;
}
