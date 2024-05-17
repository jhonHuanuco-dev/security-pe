<?php

namespace Jhonhdev\SecurityPe\Helpers;

class JsonResponse {
    public static function success($message, $datos = []) {
        return response()->json([
            'status' => true,
            'message' => $message,
            ...$datos
        ], 200);
    }

    public static function errors($message, $datos = [], $code) {
        return response()->json([
            'status' => false,
            'message' => $message,
            ...$datos
        ], $code);
    }
}
