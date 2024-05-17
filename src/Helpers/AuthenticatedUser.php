<?php

namespace Jhonhdev\SecurityPe\Helpers;

use Illuminate\Support\Facades\Auth;
use Jhonhdev\SecurityPe\Models\Schemas\Security\PersonalAccessTokens;

class AuthenticatedUser {
    public static function validateCredentials($request) {
        return Auth::attempt($request->only(['username', 'password']));
    }

    public static function validateUserState($request) {
        return Auth::attempt([
            'username' => $request->username, 
            'password' => $request->password, 
            'state' => 1
        ]);
    }

    public static function revokeTokens($id): void {
        PersonalAccessTokens::where('tokenable_id', $id)->where('expires_at', '>=', now())->delete();
    }

    public static function configTokens() {
        $token = (object) [ 
            'name' => config('securitype.session.name'), 
            'expired' => config('securitype.session.expired') 
        ];
        
        return $token;
    }
}
