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
        Schema::create('student_attendances', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->bigInteger('class_id');
            $table->bigInteger('teacher_id');
            $table->bigInteger('student_id');
            $table->string('date');
            $table->tinyInteger('attent')->default(1)->comment('0=Attent, 1=absent');
            $table->tinyInteger('status')->default(1)->comment('0=inActive, 1=Active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_attendances');
    }
};
