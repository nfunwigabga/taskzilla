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
        Schema::create('tasks', function (Blueprint $table) {
            $table->primaryKey();
            $table->string('project_id')->nullable();
            $table->string('reporter_id');
            $table->string('assignee_id')->nullable();
            $table->string('parent_id')->nullable();
            $table->string('priority_id')->nullable();
            $table->string('section_id');
            $table->string('type_id')->comment('bug, story, task, epic etc');
            $table->string('title')->fulltext();
            $table->integer('task_number')->index()->comment('eg: 100');
            $table->string('display_key', 50)->index()->comment('eg: APP-100');
            $table->longText('description')->fulltext()->nullable();
            $table->unsignedInteger('sort_order')->nullable()->index();
            $table->date('due_date')->nullable();
            $table->datetime('resolved_at')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('reporter_id')->references('id')->on('users');
            $table->foreign('assignee_id')->references('id')->on('users');
            $table->foreign('project_id')->references('id')->on('projects');
            $table->foreign('parent_id')->references('id')->on('tasks')->cascadeOnDelete();
            $table->foreign('priority_id')->references('id')->on('codes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
};
