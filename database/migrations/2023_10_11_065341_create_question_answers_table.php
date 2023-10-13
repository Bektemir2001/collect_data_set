<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('question_answers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('context_id');
            $table->text('question');
            $table->text('answer');
            $table->text('original_question')->nullable();
            $table->text('original_answer')->nullable();
            $table->string('lang')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->index('context_id', 'context_answer_question_idx');
            $table->foreign('context_id', 'context_answer_question_fk')
                ->on('contexts')
                ->references('id')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('question_answers');
    }
};
