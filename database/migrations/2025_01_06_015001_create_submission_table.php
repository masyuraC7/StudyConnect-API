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
        Schema::create('submission', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assignment_id')->constrained('assignment')->onDelete('cascade');
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->timestamp('submitted_at');
            $table->string('file_path')->nullable();
            $table->decimal('grade', 4, 1)->nullable();
            $table->enum('status', ['submitted', 'graded'])->default('submitted');
            $table->text('feedback')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Submission');
    }
};
