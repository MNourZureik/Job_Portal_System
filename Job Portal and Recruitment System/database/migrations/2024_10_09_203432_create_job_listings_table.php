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
        Schema::create('job_listings',  static function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('description');
            $table->string('job_type');
            $table->string('company');
            $table->unsignedInteger('salary');
            $table->string('location');
            $table->string('city');
            $table->string('country');
            $table->enum('work_type', ['on-site', 'remote', 'hybrid']);
            $table->string('currency');
            $table->string('salary_type');
            $table->string('start_date');
            $table->string('end_date');
            $table->string('required_skills');
            $table->foreignId('employer_id')->constrained('employers')->cascadeOnDelete();
            $table->softDeletes();
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
