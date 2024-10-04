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
        Schema::create('examp_marks', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->bigInteger('teacher_id');
            $table->bigInteger('student_id');
            $table->bigInteger('exam_id');
            $table->string('exam_typ');
            $table->float('mark',8,2);
            $table->string('publish_date');
            $table->tinyInteger('status')->default(1)->comment('0=publish, 1=unPublish');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('examp_marks');
    }
};
