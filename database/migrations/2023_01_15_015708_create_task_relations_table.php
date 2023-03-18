<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_relations', function (Blueprint $table) {
            $table->string('related_from_id')->index();
            $table->string('related_to_id');
            $table->string('relationship');
            $table->timestamps();

            $table->foreign('related_from_id')->references('id')->on('tasks')->cascadeOnDelete();
            $table->foreign('related_to_id')->references('id')->on('tasks')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('task_relations');
    }
};
