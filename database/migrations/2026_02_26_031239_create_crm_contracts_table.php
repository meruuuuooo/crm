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
        Schema::create('crm_contracts', function (Blueprint $table) {
            $table->id();
            $table->string('subject');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->foreignId('client_id')->nullable()->constrained('crm_contacts')->nullOnDelete();
            $table->string('contract_type')->nullable();
            $table->decimal('contract_value', 15, 2)->nullable();
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
        Schema::dropIfExists('crm_contracts');
    }
};
