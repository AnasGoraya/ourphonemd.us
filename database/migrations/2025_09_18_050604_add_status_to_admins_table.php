<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
{
    Schema::table('admins', function (Blueprint $table) {
        $table->string('status')->default('Pending');
    });
}

public function down()
{
    Schema::table('admins', function (Blueprint $table) {
        $table->dropColumn('status');
    });
}

}
