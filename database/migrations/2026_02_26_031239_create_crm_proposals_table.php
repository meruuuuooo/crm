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
        Schema::create('crm_proposals', function (Blueprint $table) {
            $table->id();
            $table->string('subject');
            $table->date('date')->nullable();
            $table->date('open_till')->nullable();
            $table->foreignId('client_id')->nullable()->constrained('crm_contacts')->nullOnDelete();
            $table->foreignId('project_id')->nullable()->constrained('crm_projects')->nullOnDelete();
            $table->string('related_to')->nullable();
            $table->foreignId('deal_id')->nullable()->constrained('crm_deals')->nullOnDelete();
            $table->string('currency')->nullable();
            $table->string('status')->nullable();
            $table->string('attachment')->nullable();
            $table->string('tags')->nullable();
            $table->longText('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // Pivot: proposals <-> assignees
        Schema::create('crm_proposal_assignee', function (Blueprint $table) {
            $table->foreignId('proposal_id')->constrained('crm_proposals')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->primary(['proposal_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crm_proposal_assignee');
        Schema::dropIfExists('crm_proposals');
    }
};
