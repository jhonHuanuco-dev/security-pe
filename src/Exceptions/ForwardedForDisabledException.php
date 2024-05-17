<?php

namespace Jhonhdev\SecurityPe\Exceptions;

use Exception;

class ForwardedForDisabledException extends Exception
{
    public function __construct($message = 'Error: Habilite la opcion [config > proxy > forwarded_for_on].') {
        parent::__construct($message);
    }
}
