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
        Schema::create('instructors', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->bigInteger('user_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('professional_title')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('address')->nullable();
            $table->string('gender', 50)->nullable();
            $table->string('slug')->nullable();
            $table->string('is_private', 10)->default('no')->comment('yes, no');
            $table->string('remove_from_web_search', 10)->default('no')->comment('yes, no');
            $table->tinyInteger('status')->default(0)->comment('0=pending, 1=approved, 2=blocked');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instructors');
    }
};
