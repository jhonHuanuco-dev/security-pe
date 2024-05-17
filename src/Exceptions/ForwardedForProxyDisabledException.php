<?php

namespace Jhonhdev\SecurityPe\Exceptions;

use Exception;

class ForwardedForProxyDisabledException extends Exception
{
    public function __construct($message = 'Error: Habilite la cabecera HTTP_X_FORWARDED_FOR en su proxy o deshabilite la opcion [config > proxy > enable].') {
        parent::__construct($message);
    }
}
