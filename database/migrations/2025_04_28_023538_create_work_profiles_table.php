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
            $table->foreignIdFor(User::class)->constrained()->onDelete('cascade');
            $table->string('profession');
            $table->string('profile_picture')->nullable();
            $table->text('overview');
            $table->string('phone_number', 13);
            $table->date('birthday');
            $table->enum('experience_level', ['Entry', 'Mid', 'Senior']);
            $table->string('expected_salary')->nullable();
            $table->json('skills')->nullable();
            $table->boolean('is_open_to_work')->default(true);
            $table->boolean('is_banned')->default(false);
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
