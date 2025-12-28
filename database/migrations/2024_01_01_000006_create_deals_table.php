<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('deals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->onDelete('cascade');
            $table->foreignId('account_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('contact_id')->nullable()->constrained()->onDelete('set null');
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('value', 15, 2);
            $table->string('currency', 3)->default('USD');
            $table->string('stage');
            $table->integer('probability')->default(0);
            $table->date('expected_close_date')->nullable();
            $table->date('actual_close_date')->nullable();
            $table->string('status')->default('open');
            $table->decimal('ai_score', 5, 2)->nullable();
            $table->timestamp('won_at')->nullable();
            $table->timestamp('lost_at')->nullable();
            $table->text('lost_reason')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deals');
    }
};

