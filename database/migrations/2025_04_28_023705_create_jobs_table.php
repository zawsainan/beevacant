<?php

use App\Models\Company;
use App\Models\Industry;
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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Company::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Industry::class)->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('salary_range')->nullable();
            $table->enum('schedule', ['Part Time', 'Full Time'])->default('Full Time');
            $table->string('location');
            $table->boolean('is_featured')->default(false);
            $table->longText('description');
            $table->longText('requirements')->nullable();
            $table->date('deadline')->nullable();
            $table->enum('experience_level', ['Entry', 'Mid', 'Senior'])->nullable();
            $table->boolean('is_remote')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
