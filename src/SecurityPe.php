<?php

namespace Jhonhdev\SecurityPe;

use Jhonhdev\SecurityPe\Exceptions\ForwardedForDisabledException;
use Jhonhdev\SecurityPe\Exceptions\ForwardedForProxyDisabledException;
use Jhonhdev\SecurityPe\Helpers\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Jhonhdev\SecurityPe\Helpers\AuthenticatedUser;

class SecurityPe 
{
    /**
     * Indicates if SecurityPe's migrations will be run.
     *
     * @var bool
     */
    public static $runsMigrations = true;

    /**
     * Determine if Sanctum's migrations should be run.
     *
     * @return bool
     */
    public static function shouldRunMigrations() {
        if (config('securitype.only_bridge', false) === true) {
            return static::$runsMigrations = false;
        }

        return static::$runsMigrations;
    }

    /**
     * Configure Sanctum to not register its migrations.
     *
     * @return static
     */
    public static function ignoreMigrations() {
        static::$runsMigrations = false;
        return new static;
    }

    public static function ipAddress($request) {
        $ip_address = $request->ip();
        if (config('securitype.proxy.enable', false) === true) {
            if (config('securitype.proxy.forwarded_for_on', false) === true) {
                if (in_array($ip_address, config('securitype.proxy.servers'))) {
                    if (empty($request->server('HTTP_X_FORWARDED_FOR'))) {
                        throw new ForwardedForProxyDisabledException;
                    }
                    
                    $ip_address = $request->server('HTTP_X_FORWARDED_FOR');
                }
            } else {
                throw new ForwardedForDisabledException;
            }
        }

        return $ip_address;
    }

    public static function response() {
        return new JsonResponse;
    }

    public static function auth() {
        return new AuthenticatedUser;
    }
}
