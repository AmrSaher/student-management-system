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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone_number');
            $table->string('parents_phone_number');
            $table->string('address');
            $table->text('image_path');
            $table->string('slug')->unique();
            $table->unsignedBigInteger('grade_id');
            $table->unsignedBigInteger('appointment_id');
            $table->boolean('isExist')->default(true);
            $table->date('paid_at')->default(now())->nullable();

//            $table->foreign('grade_id')
//                ->references('id')
//                ->on('grades')
//                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
