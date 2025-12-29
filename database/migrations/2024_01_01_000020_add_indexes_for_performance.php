<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add indexes for frequently queried columns
        Schema::table('accounts', function (Blueprint $table) {
            $table->index('tenant_id');
            $table->index('status');
            $table->index(['tenant_id', 'status']);
        });

        Schema::table('contacts', function (Blueprint $table) {
            $table->index('tenant_id');
            $table->index('account_id');
            $table->index('status');
            $table->index(['tenant_id', 'account_id']);
        });

        Schema::table('leads', function (Blueprint $table) {
            $table->index('tenant_id');
            $table->index('status');
            $table->index('source');
            $table->index(['tenant_id', 'status']);
        });

        Schema::table('deals', function (Blueprint $table) {
            $table->index('tenant_id');
            $table->index('account_id');
            $table->index('status');
            $table->index('stage');
            $table->index(['tenant_id', 'status', 'stage']);
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->index('tenant_id');
            $table->index('account_id');
            $table->index('status');
            $table->index(['tenant_id', 'status']);
        });

        Schema::table('tasks', function (Blueprint $table) {
            $table->index('tenant_id');
            $table->index('project_id');
            $table->index('status');
            $table->index('priority');
            $table->index(['tenant_id', 'project_id']);
        });

        Schema::table('invoices', function (Blueprint $table) {
            $table->index('tenant_id');
            $table->index('account_id');
            $table->index('status');
            $table->index(['tenant_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::table('accounts', function (Blueprint $table) {
            $table->dropIndex(['tenant_id']);
            $table->dropIndex(['status']);
            $table->dropIndex(['tenant_id', 'status']);
        });

        Schema::table('contacts', function (Blueprint $table) {
            $table->dropIndex(['tenant_id']);
            $table->dropIndex(['account_id']);
            $table->dropIndex(['status']);
            $table->dropIndex(['tenant_id', 'account_id']);
        });

        Schema::table('leads', function (Blueprint $table) {
            $table->dropIndex(['tenant_id']);
            $table->dropIndex(['status']);
            $table->dropIndex(['source']);
            $table->dropIndex(['tenant_id', 'status']);
        });

        Schema::table('deals', function (Blueprint $table) {
            $table->dropIndex(['tenant_id']);
            $table->dropIndex(['account_id']);
            $table->dropIndex(['status']);
            $table->dropIndex(['stage']);
            $table->dropIndex(['tenant_id', 'status', 'stage']);
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->dropIndex(['tenant_id']);
            $table->dropIndex(['account_id']);
            $table->dropIndex(['status']);
            $table->dropIndex(['tenant_id', 'status']);
        });

        Schema::table('tasks', function (Blueprint $table) {
            $table->dropIndex(['tenant_id']);
            $table->dropIndex(['project_id']);
            $table->dropIndex(['status']);
            $table->dropIndex(['priority']);
            $table->dropIndex(['tenant_id', 'project_id']);
        });

        Schema::table('invoices', function (Blueprint $table) {
            $table->dropIndex(['tenant_id']);
            $table->dropIndex(['account_id']);
            $table->dropIndex(['status']);
            $table->dropIndex(['tenant_id', 'status']);
        });
    }
};

