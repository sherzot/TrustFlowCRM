<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ai_calls', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('tenant_id')->nullable()->index()->constrained()->nullOnDelete();
            $table->foreignId('user_id')->nullable()->index()->constrained('users')->nullOnDelete();
            $table->string('feature', 64)->index();
            $table->string('model', 64);
            $table->unsignedInteger('prompt_tokens')->default(0);
            $table->unsignedInteger('completion_tokens')->default(0);
            $table->unsignedInteger('total_tokens')->default(0);
            $table->decimal('cost_usd', 12, 6)->default(0);
            $table->unsignedInteger('latency_ms')->default(0);
            $table->string('error', 255)->nullable();
            $table->json('metadata')->nullable();
            $table->text('prompt_preview')->nullable();
            $table->text('response_preview')->nullable();
            $table->timestamps();

            $table->index(['tenant_id', 'feature', 'created_at'], 'ai_calls_tenant_feature_created_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_calls');
    }
};
