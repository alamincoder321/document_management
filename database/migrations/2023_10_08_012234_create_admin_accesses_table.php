<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminAccessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_accesses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->constrained('admins', 'id')->onDelete('cascade');
            $table->string('group_name', 100);
            $table->string('permissions', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_accesses');
    }
}
