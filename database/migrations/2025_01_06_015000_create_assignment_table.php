<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('assignment', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100);
            $table->text('description')->nullable();
            $table->foreignId('class_id')->constrained('classes')->onDelete('cascade');
            $table->dateTime('due_date')->nullable();
            $table->string('attachment_path')->nullable();
            $table->integer('max_score', false, true)->length(3);
            $table->enum('type', ['essay', 'multiple_choice', 'file_upload']);
            $table->json('options')->nullable();
            $table->dateTime('scheduled_at')->nullable();
            $table->enum('status', ['scheduled', 'published'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignment');
    }
};
