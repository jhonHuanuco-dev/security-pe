<?php

namespace Jhonhdev\SecurityPe\Models\Schemas\Security;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Activity extends Model
{
    use Prunable;

    protected $connection;
    protected $table;
    protected $guard_name = 'api';
    public $timestamps = false;

    public function __construct() {
        $this->connection = config('securitype.connection');
        $this->table = config('securitype.models.activity.name');
    }

    protected $fillable = [
        'user_id',
        'url',
        'user_agent',
        'method',
        'ip_address',
    ];

    protected $hidden = [
        'id',
        'user_id',
        'url',
        'user_agent',
        'method',
        'ip_address',
        'created_at',
    ];

    protected static function booted(): void {
        //
    }

    public function prunable(): Builder {
        return static::where('created_at', '<=', now()->subDays(7));
    }

    public function user(): BelongsTo {
        return $this->belongsTo(Users::class, 'id');
    }
}
