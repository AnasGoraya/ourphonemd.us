<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateStatusInTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Purana column drop karke naya column create kar do
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('tasks', function (Blueprint $table) {
            $table->enum('status', ['Pending', 'Done', 'Resolve'])->default('Pending');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Dobara drop aur purana column wapis create
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('tasks', function (Blueprint $table) {
            $table->boolean('status')->default(0);
        });
    }
}
