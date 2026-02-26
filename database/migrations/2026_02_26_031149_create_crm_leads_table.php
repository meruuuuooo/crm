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
        Schema::create('crm_leads', function (Blueprint $table) {
            $table->id();
            $table->string('lead_name');
            $table->string('lead_type')->default('individual'); // individual / company
            $table->foreignId('company_id')->nullable()->constrained('crm_companies')->nullOnDelete();
            $table->decimal('value', 15, 2)->nullable();
            $table->string('currency')->nullable();
            $table->string('phone')->nullable();
            $table->string('phone_type')->nullable(); // Work / Home
            $table->string('source')->nullable();
            $table->string('industry')->nullable();
            $table->string('tags')->nullable();
            $table->text('description')->nullable();
            $table->string('visibility')->default('public');
            $table->timestamps();
            $table->softDeletes();
        });

        // Pivot: leads <-> owners (users)
        Schema::create('crm_lead_owner', function (Blueprint $table) {
            $table->foreignId('lead_id')->constrained('crm_leads')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->primary(['lead_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crm_lead_owner');
        Schema::dropIfExists('crm_leads');
    }
};
