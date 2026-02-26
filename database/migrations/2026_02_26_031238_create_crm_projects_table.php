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
        Schema::create('crm_projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('project_id_code')->nullable();
            $table->string('project_type')->nullable();
            $table->foreignId('client_id')->nullable()->constrained('crm_contacts')->nullOnDelete();
            $table->string('category')->nullable();
            $table->string('project_timing')->nullable();
            $table->decimal('price', 15, 2)->nullable();
            $table->date('start_date')->nullable();
            $table->date('due_date')->nullable();
            $table->string('priority')->nullable();
            $table->string('status')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // Pivot: projects <-> responsible persons
        Schema::create('crm_project_responsible', function (Blueprint $table) {
            $table->foreignId('project_id')->constrained('crm_projects')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->primary(['project_id', 'user_id']);
        });

        // Pivot: projects <-> team leaders
        Schema::create('crm_project_leader', function (Blueprint $table) {
            $table->foreignId('project_id')->constrained('crm_projects')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->primary(['project_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crm_project_leader');
        Schema::dropIfExists('crm_project_responsible');
        Schema::dropIfExists('crm_projects');
    }
};
