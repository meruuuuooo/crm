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
        Schema::create('crm_campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('campaign_type')->nullable();
            $table->decimal('deal_value', 15, 2)->nullable();
            $table->string('currency')->nullable();
            $table->string('period')->nullable();
            $table->decimal('period_value', 15, 2)->nullable();
            $table->string('target_audience')->nullable();
            $table->text('description')->nullable();
            $table->string('attachment')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crm_campaigns');
    }
};
