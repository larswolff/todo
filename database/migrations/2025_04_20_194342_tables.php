<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('name');
            $table->text('note')->nullable();
            $table->date('defer_date')->nullable();
            $table->date('due_date')->nullable();
            $table->datetime('reviewed_at')->nullable();
            $table->boolean('is_sequential')->default(false); // false => parallel, true => sequential
            $table->string('status')->default('ready'); // ready, completed, inactive, cancelled, someday
            $table->timestamps();
        });

        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('project_id')->nullable()->constrained('projects');
            $table->string('title');
            $table->text('note')->nullable();
            $table->date('defer_date')->nullable();      // date after which the task becomes active
            $table->date('due_date')->nullable();        // optional hard or soft due date
            $table->string('status')->default('ready'); // ready, completed, next, someday (virtual override from tag: waiting,
            // and from project or task: deferred)
            $table->unsignedInteger('sequence_order')->default(1); // for ordering tasks in a sequential project
            $table->string('recurrence_rule')->nullable();
            $table->boolean('flagged')->default(false);
            $table->timestamps();
        });

        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('name');
            $table->timestamps();
            $table->datetime('reviewed_at')->nullable();
        });

        Schema::create('tag_project', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects');
            $table->foreignId('tag_id')->constrained('tags');
            $table->timestamps();
        });


        Schema::create('tag_task', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained('tasks');
            $table->foreignId('tag_id')->constrained('tags');
            $table->timestamps();
        });

        Schema::create('reference_materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->text('note')->nullable();         // reference note content
            $table->string('url')->nullable();        // link to an external resource, if needed
            $table->timestamps();
        });
    }
};
