<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->onDelete('cascade');
            $table->string('source');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('company')->nullable();
            $table->string('title')->nullable();
            $table->string('website')->nullable();
            $table->string('industry')->nullable();
            $table->text('description')->nullable();
            $table->string('status')->default('new');
            $table->decimal('ai_score', 5, 2)->nullable();
            $table->timestamp('converted_at')->nullable();
            $table->foreignId('converted_to_account_id')->nullable()->constrained('accounts')->onDelete('set null');
            $table->foreignId('converted_to_contact_id')->nullable()->constrained('contacts')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};

