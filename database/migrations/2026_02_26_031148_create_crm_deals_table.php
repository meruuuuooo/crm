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
        Schema::create('crm_deals', function (Blueprint $table) {
            $table->id();
            $table->string('deal_name');
            $table->unsignedBigInteger('pipeline_id')->nullable(); // FK added after crm_pipelines
            $table->string('status')->nullable();
            $table->decimal('deal_value', 15, 2)->nullable();
            $table->string('currency')->nullable();
            $table->string('period')->nullable();
            $table->decimal('period_value', 15, 2)->nullable();
            $table->string('project')->nullable();
            $table->date('due_date')->nullable();
            $table->date('expected_closing_date')->nullable();
            $table->date('follow_up_date')->nullable();
            $table->string('source')->nullable();
            $table->string('tags')->nullable();
            $table->string('priority')->nullable();
            $table->longText('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // Pivot: deals <-> contacts
        Schema::create('crm_deal_contact', function (Blueprint $table) {
            $table->foreignId('deal_id')->constrained('crm_deals')->cascadeOnDelete();
            $table->foreignId('contact_id')->constrained('crm_contacts')->cascadeOnDelete();
            $table->primary(['deal_id', 'contact_id']);
        });

        // Pivot: deals <-> assignees (users)
        Schema::create('crm_deal_assignee', function (Blueprint $table) {
            $table->foreignId('deal_id')->constrained('crm_deals')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->primary(['deal_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crm_deal_assignee');
        Schema::dropIfExists('crm_deal_contact');
        Schema::dropIfExists('crm_deals');
    }
};
