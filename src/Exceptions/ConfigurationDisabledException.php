<?php

namespace Jhonhdev\SecurityPe\Exceptions;

use Exception;

class ConfigurationDisabledException extends Exception
{
    public function __construct($message = 'Advertencia: El archivo config/securitype.php no está importado. Ejecute php artisan config:clear e intente nuevamente.') {
        parent::__construct($message);
    }
}
