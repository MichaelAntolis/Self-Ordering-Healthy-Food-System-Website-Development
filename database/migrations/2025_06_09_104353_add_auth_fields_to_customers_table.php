<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->string('password')->after('email');
            $table->timestamp('email_verified_at')->nullable()->after('password');
            $table->string('remember_token')->nullable()->after('email_verified_at');
            $table->boolean('is_active')->default(true)->after('remember_token');
            $table->timestamp('last_login_at')->nullable()->after('is_active');
        });
    }

    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn([
                'password',
                'email_verified_at', 
                'remember_token',
                'is_active',
                'last_login_at'
            ]);
        });
    }
};