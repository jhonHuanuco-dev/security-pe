<?php

namespace Jhonhdev\SecurityPe\Models\Schemas\Security;

use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;

class PersonalAccessTokens extends SanctumPersonalAccessToken
{
    protected $connection;
    protected $table;
    protected $guard_name = 'api';

    public function __construct() {
        $this->connection = config('securitype.connection');
        $this->table = config('securitype.models.personal_access_tokens.name');
    }

    protected $fillable = [
        'name',
        'ip',
        'token',
        'abilities',
        'expires_at',
    ];
    
    protected $hidden = [
        'token',
    ];
}
