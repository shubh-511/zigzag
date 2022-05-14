<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
        'payment-status',
        'api/login',
        'api/signup_as_user',
        'api/forgot_password',
        'api/edit_profile/{id?}',
        'api/change_password/{id?}',
        'api/*',
        'addmoney/stripe',
    ];
}
