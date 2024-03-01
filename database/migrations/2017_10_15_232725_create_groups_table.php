<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('group_user', function (Blueprint $table) {
            $table->integer('group_id');
            $table->string('user_id');
            $table->timestamps();

            $table->index(['group_id', 'user_id']);
        });

        Schema::create('groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('type');
            $table->date('date_start');
            $table->date('date_end');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('groups');
    }
};
