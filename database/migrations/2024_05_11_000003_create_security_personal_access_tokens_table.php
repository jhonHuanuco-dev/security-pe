<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Jhonhdev\SecurityPe\Exceptions\ConfigurationDisabledException;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $connection = config('securitype.connection');
        $table_name = config('securitype.models.personal_access_tokens.name');
        if (empty($connection)) {
            throw new ConfigurationDisabledException;
        }
        
        Schema::connection($connection)->create($table_name, function (Blueprint $table) {
            $table->id();
            $table->morphs('tokenable');
            $table->string('name');
            $table->string('ip', 15);
            $table->string('token', 64)->unique();
            $table->text('abilities')->nullable();
            $table->timestamp('last_used_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $connection = config('securitype.connection');
        $table_name = config('securitype.models.personal_access_tokens.name');
        if (empty($connection)) {
            throw new ConfigurationDisabledException;
        }

        Schema::connection($connection)->dropIfExists($table_name);
    }
};
