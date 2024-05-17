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
        $table_name = config('securitype.models.users.name');
        $table_name_brach = config('securitype.models.branches.name');

        if (empty($connection)) {
            throw new ConfigurationDisabledException;
        }

        Schema::connection($connection)->create($table_name, function (Blueprint $table) use ($table_name_brach) {
            $table->id();
            $table->unsignedSmallInteger('branch_id');
            $table->string('username', 8);
            $table->string('name');
            $table->string('last_name');
            $table->string('email');
            $table->integer('extension')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->boolean('state')->default(1);
            $table->string('created_by', 8);
            $table->timestamp('created_at', 0)->useCurrent();
            $table->string('updated_by', 8)->nullable();
            $table->timestamp('updated_at', 0)->useCurrentOnUpdate()->nullable();
            $table->timestamp('deleted_at', 0)->nullable();

            $table->index(['username', 'password'], 'IDX__SU_UP');
            $table->index(['email'], 'IDX__SU_EMA');
            $table->index(['extension'], 'IDX__SU_EXT');
            $table->unique(['email','deleted_at'], 'UQ__SU_EDA');
            $table->foreign('branch_id', 'FK__SU_BII')->references('id')->on($table_name_brach);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $connection = config('securitype.connection');
        $table_name = config('securitype.models.users.name');
        if (empty($connection)) {
            throw new ConfigurationDisabledException;
        }

        Schema::connection($connection)->dropIfExists($table_name);
    }
};
