<?php

namespace Jhonhdev\SecurityPe\Models\Schemas\Security;


use Illuminate\Foundation\Auth\User as Authenticatable;
use Jhonhdev\SecurityPe\Traits\HasApiTokens;

class Users extends Authenticatable
{
    use HasApiTokens;

    protected $connection;
    protected $table;
    protected $guard_name = 'api';

    public function __construct() {
        $this->connection = config('securitype.connection');
        $this->table = config('securitype.models.users.name');
    }

    protected $fillable = [
        'branch_id',
        'username',
        'name',
        'last_name',
        'email',
        'extension',
        'password',
        'state',
        'created_by',
    ];

    protected $hidden = [
        'id',
        'password',
        'remember_token',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'branch_id' => 'integer',
        'extension' => 'integer',
        'password' => 'hashed',
        'state' => 'bool',
    ];
}