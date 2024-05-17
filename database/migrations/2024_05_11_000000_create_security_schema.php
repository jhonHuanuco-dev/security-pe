<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (config('database.connections.default.driver') === 'pgsql') {
            DB::statement('CREATE SCHEMA IF NOT EXISTS security');
        } elseif (config('database.connections.default.driver') === 'sqlsrv') {
            DB::statement("IF NOT EXISTS (SELECT * FROM sys.schemas WHERE name = 'security') BEGIN EXEC('CREATE SCHEMA security') END");
        }
    }

    public function down(): void
    {
        //...
    }
};
