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
        Schema::create('crm_activities', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('activity_type')->nullable(); // call / meeting / email / etc.
            $table->date('due_date')->nullable();
            $table->time('time')->nullable();
            $table->integer('reminder_value')->nullable();
            $table->string('reminder_unit')->nullable(); // Minutes / Hours
            $table->foreignId('owner_id')->nullable()->constrained('users')->nullOnDelete();
            $table->longText('description')->nullable();
            $table->foreignId('deal_id')->nullable()->constrained('crm_deals')->nullOnDelete();
            $table->foreignId('contact_id')->nullable()->constrained('crm_contacts')->nullOnDelete();
            $table->foreignId('company_id')->nullable()->constrained('crm_companies')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        // Pivot: activities <-> guests (users)
        Schema::create('crm_activity_guest', function (Blueprint $table) {
            $table->foreignId('activity_id')->constrained('crm_activities')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->primary(['activity_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crm_activity_guest');
        Schema::dropIfExists('crm_activities');
    }
};
