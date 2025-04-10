<?php

use App\Models\User;
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
        Schema::create('work_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->boolean('employment_status')->default(true);
            $table->enum('experience_level', ['Entry', 'Mid', 'Senior']);
            $table->integer('expected_salary')->nullable();
            $table->text('overview')->nullable();
            $table->json('skills')->nullable();
            $table->string('profile_picture');
            $table->date('birthday');
            $table->string('phone_number', 10);
            $table->string('profession');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_profiles');
    }
};
