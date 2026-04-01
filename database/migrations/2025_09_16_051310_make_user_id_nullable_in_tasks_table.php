<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeUserIdNullableInTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
public function up()
{
    Schema::table('tasks', function (Blueprint $table) {
        $table->dropColumn('user_id');
    });

    Schema::table('tasks', function (Blueprint $table) {
        $table->unsignedBigInteger('user_id')->nullable()->after('status');
    });
}


}
