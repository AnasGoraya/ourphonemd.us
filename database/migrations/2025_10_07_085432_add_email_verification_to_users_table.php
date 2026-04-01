<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmailVerificationToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'verification_token')) {
                $table->string('verification_token')->nullable();
            }
            if (!Schema::hasColumn('users', 'email_verified_at')) {
                $table->timestamp('email_verified_at')->nullable();
            }
            if (!Schema::hasColumn('users', 'email_status')) {
                $table->string('email_status')->nullable()->default('Unverified');
            }
        });
    }

    public function down()
    {
        // down method optional کر دو تاکہ rollback پہ error نہ دے
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'verification_token')) {
                $table->dropColumn('verification_token');
            }
            if (Schema::hasColumn('users', 'email_verified_at')) {
                $table->dropColumn('email_verified_at');
            }
            if (Schema::hasColumn('users', 'email_status')) {
                $table->dropColumn('email_status');
            }
        });
    }
}
