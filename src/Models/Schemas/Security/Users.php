<?php

namespace Jhonhdev\SecurityPe\Models\Schemas\Security;


use Illuminate\Foundation\Auth\User as Authenticatable;
use Jhonhdev\SecurityPe\Traits\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function activitys(): HasMany {
        return $this->hasMany(Activity::class, 'user_id');
    }

    public function branche(): BelongsTo {
        return $this->belongsTo(Branches::class, 'id');
    }
}
