<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->primaryKey();
            $table->foreignKey('user_id')->constrained();
            $table->string('name');
            $table->string('color', 100)->nullable();
            $table->string('icon', 100)->nullable();
            $table->longText('description')->nullable();
            $table->string('code', 5)
                ->comment('Prefix to all tasks. eg TSK');
            $table->date('start_date')->nullable();
            $table->date('due_date')->nullable();
            $table->longText('settings')->nullable();
            $table->timestamp('archived_at')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('projects');
    }
};
