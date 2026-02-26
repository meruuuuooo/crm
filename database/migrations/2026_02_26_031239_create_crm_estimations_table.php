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
        Schema::create('crm_estimations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->nullable()->constrained('crm_contacts')->nullOnDelete();
            $table->text('bill_to')->nullable();
            $table->text('ship_to')->nullable();
            $table->foreignId('project_id')->nullable()->constrained('crm_projects')->nullOnDelete();
            $table->string('estimate_by')->nullable();
            $table->decimal('amount', 15, 2)->nullable();
            $table->string('currency')->nullable();
            $table->date('estimate_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->string('status')->nullable();
            $table->string('tags')->nullable();
            $table->string('attachment')->nullable();
            $table->longText('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crm_estimations');
    }
};
