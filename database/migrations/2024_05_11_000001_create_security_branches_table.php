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
        $table_name = config('securitype.models.branches.name');
        if (empty($connection)) {
            throw new ConfigurationDisabledException;
        }

        Schema::connection($connection)->create($table_name, function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('country', 25);
            $table->string('name', 50);
            $table->string('phone')->nullable();
            $table->string('company', 125)->nullable();
            $table->string('db_connection', 50)->default('default');
            $table->boolean('state')->default(1);

            $table->index(['id','db_connection','state'], 'IDX__SB_IDCS');
        });
    }

    public function down(): void
    {
        $connection = config('securitype.connection');
        $table_name = config('securitype.models.branches.name');
        if (empty($connection)) {
            throw new ConfigurationDisabledException;
        }
        
        Schema::connection($connection)->dropIfExists($table_name);
    }
};
