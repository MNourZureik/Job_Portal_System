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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->enum('access_level', ['low', 'medium', 'high'])->default('low');
            // low : can manage jobSeekers .
            // medium : can manage jobSeekers && Employers .
            // high : can manage all users : [admins , employers , jobSeekers] // super admin;
            $table->enum('status' , ['active' , 'inactive' , 'suspended'])->default('inactive');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
