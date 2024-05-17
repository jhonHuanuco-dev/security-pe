<?php

namespace Jhonhdev\SecurityPe\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Jhonhdev\SecurityPe\Http\Requests\Security\SecurityPeRequest;
use Jhonhdev\SecurityPe\Models\Schemas\Security\PersonalAccessTokens;
use Jhonhdev\SecurityPe\SecurityPe;

class SecurityPeController
{
    public function authentication(SecurityPeRequest $request) {
        $ip_address = SecurityPe::ipAddress($request);
        if (SecurityPe::auth()->validateCredentials($request)) {
            if (SecurityPe::auth()->validateUserState($request)) {
                $user = User::where('username', $request->username)->first();

                $sessions = PersonalAccessTokens::where('tokenable_id', $user->id)->where('expires_at', '>=', now())->get();
                foreach ($sessions as $session) {
                    $session = (object) $session;
                    if ($session->ip != $ip_address) {
                        return SecurityPe::response()->errors('Ya existe una sessión activa en otro ordenador.', [], 401);
                    }
                }

                try {
                    DB::beginTransaction();
                    SecurityPe::auth()->revokeTokens($user->id);
                    $token = SecurityPe::auth()->configTokens();
                    $create_token = $user->createToken($token->name, ['*'], $token->expired, $ip_address)->plainTextToken;
                    DB::commit();   

                    return SecurityPe::response()->success('Bienvenido '.$user->name, [
                        'user' => $user,
                        'token' => [
                            'key' => $create_token,
                            'expired' => date_format($token->expired, 'Y-m-d H:i:s')
                        ]
                    ]);
                } catch (\Throwable $th) {
                    DB::rollBack();
                    return SecurityPe::response()->errors('Ha ocurrido un error.', [
                        'detalles' => $th->getMessage()
                    ], 500);
                }
            }

            return SecurityPe::response()->errors('Su usuario se encuetra inactivo, por favor contacte al administador.', [], 401);
        }

        return SecurityPe::response()->errors('Las credenciales no existen o están incorrectas.', [], 401);
    }

    public function unauthentication(Request $request) {
        PersonalAccessTokens::findToken($request->bearerToken())->delete();
        return SecurityPe::response()->success('Hasta pronto.', []);
    }

    public function validateToken(Request $request) {
        $ip_address = SecurityPe::ipAddress($request);
        if ($ip_address != PersonalAccessTokens::where('tokenable_id', auth()->user()->id)->where('expires_at', '>=', now())->first()->ip) {
            PersonalAccessTokens::findToken($request->bearerToken())->delete();

            return SecurityPe::response()->errors('Se ha detectado un token de sesión clonado, comuníquese con el administrador.', [], 401);
        }

        return SecurityPe::response()->success('Ok', []);
    }
}
