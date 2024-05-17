<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Jhonhdev\SecurityPe\Exceptions\ConfigurationDisabledException;

return new class extends Migration
{
    public function up(): void
    {
        $connection = config('securitype.connection');
        $table_name = config('securitype.models.activity.name');
        if (empty($connection)) {
            throw new ConfigurationDisabledException;
        }

        Schema::connection($connection)->create($table_name, function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('url');
            $table->text('user_agent')->nullable();
            $table->string('method');
            $table->string('ip_address');
            $table->timestamp('created_at', 0)->nullable();
        });
    }

    public function down(): void
    {
        $connection = config('securitype.connection');
        $table_name = config('securitype.models.activity.name');
        if (empty($connection)) {
            throw new ConfigurationDisabledException;
        }
        
        Schema::connection($connection)->dropIfExists($table_name);
    }
};
