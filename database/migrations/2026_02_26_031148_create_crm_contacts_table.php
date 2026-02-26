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
        Schema::create('crm_contacts', function (Blueprint $table) {
            $table->id();
            $table->string('profile_image')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('job_title')->nullable();
            $table->foreignId('company_id')->nullable()->constrained('crm_companies')->nullOnDelete();
            $table->string('email')->nullable();
            $table->boolean('email_opt_out')->default(false);
            $table->string('phone_1')->nullable();
            $table->string('phone_2')->nullable();
            $table->string('fax')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('reviews')->nullable();
            $table->foreignId('owner_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('tags')->nullable();
            $table->string('source')->nullable();
            $table->string('industry')->nullable();
            $table->string('currency')->nullable();
            $table->string('language')->nullable();
            $table->text('description')->nullable();
            // Address
            $table->string('street_address')->nullable();
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('zipcode')->nullable();
            // Social
            $table->string('facebook')->nullable();
            $table->string('skype')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('twitter')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('instagram')->nullable();
            // Access
            $table->string('visibility')->default('public');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crm_contacts');
    }
};
