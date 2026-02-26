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
        Schema::create('crm_invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->nullable()->constrained('crm_contacts')->nullOnDelete();
            $table->text('bill_to')->nullable();
            $table->text('ship_to')->nullable();
            $table->foreignId('project_id')->nullable()->constrained('crm_projects')->nullOnDelete();
            $table->decimal('amount', 15, 2)->nullable();
            $table->string('currency')->nullable();
            $table->date('date')->nullable();
            $table->date('open_till')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('status')->nullable();
            $table->longText('description')->nullable();
            $table->json('line_items')->nullable(); // [{item, quantity, price, discount, line_amount}]
            $table->text('notes')->nullable();
            $table->text('terms_conditions')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crm_invoices');
    }
};
