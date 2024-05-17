<?php

namespace Jhonhdev\SecurityPe\Models\Schemas\Security;

use Illuminate\Database\Eloquent\Model;

class Branches extends Model 
{
    protected $connection;
    protected $table;
    protected $guard_name = 'api';
    public $timestamps = false;

    public function __construct() {
        $this->connection = config('securitype.connection');
        $this->table = config('securitype.models.branches.name');
    }

    protected $fillable = [
        'country',
        'name',
        'phone',
        'company',
        'db_connection',
        'state',
    ];

    protected $hidden = [
        'id',
        'db_connection',
        'state',
    ];

    protected $casts = [
        'state' => 'bool',
    ];
}