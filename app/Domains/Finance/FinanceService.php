<?php

namespace App\Domains\Finance;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Project;
use Illuminate\Support\Str;

class FinanceService
{
    /**
     * Invoice yaratish Project dan
     */
    public function createInvoiceFromProject(Project $project, array $data = []): Invoice
    {
        $invoice = Invoice::create([
            'tenant_id' => $project->tenant_id,
            'project_id' => $project->id,
            'account_id' => $project->account_id,
            'invoice_number' => $this->generateInvoiceNumber($project->tenant_id),
            'issue_date' => $data['issue_date'] ?? now(),
            'due_date' => $data['due_date'] ?? now()->addDays(30),
            'currency' => $project->currency,
            'subtotal' => $project->budget ?? 0,
            'tax_rate' => $data['tax_rate'] ?? 0,
            'tax_amount' => ($project->budget ?? 0) * ($data['tax_rate'] ?? 0) / 100,
            'total' => ($project->budget ?? 0) * (1 + ($data['tax_rate'] ?? 0) / 100),
            'status' => 'draft',
        ]);

        // Invoice items qo'shish
        if (isset($data['items'])) {
            foreach ($data['items'] as $item) {
                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'description' => $item['description'],
                    'quantity' => $item['quantity'] ?? 1,
                    'unit_price' => $item['unit_price'],
                    'total' => ($item['quantity'] ?? 1) * $item['unit_price'],
                ]);
            }
        }

        return $invoice;
    }

    /**
     * Invoice raqamini yaratish
     */
    protected function generateInvoiceNumber(int $tenantId): string
    {
        $year = now()->year;
        $month = now()->format('m');
        $lastInvoice = Invoice::where('tenant_id', $tenantId)
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', now()->month)
            ->orderBy('id', 'desc')
            ->first();

        $number = $lastInvoice ? ((int) substr($lastInvoice->invoice_number, -4)) + 1 : 1;

        return sprintf('INV-%s%s-%04d', $year, $month, $number);
    }

    /**
     * Invoice ni to'lash
     */
    public function markInvoiceAsPaid(Invoice $invoice, float $amount): Invoice
    {
        $invoice->update([
            'status' => 'paid',
            'paid_at' => now(),
            'paid_amount' => $amount,
        ]);

        return $invoice;
    }

    /**
     * ROI hisoblash
     */
    public function calculateROI(int $tenantId, string $period = 'month'): array
    {
        $query = Invoice::where('tenant_id', $tenantId)
            ->where('status', 'paid');

        if ($period === 'month') {
            $query->whereMonth('paid_at', now()->month)
                  ->whereYear('paid_at', now()->year);
        } elseif ($period === 'year') {
            $query->whereYear('paid_at', now()->year);
        }

        $revenue = $query->sum('total');
        $costs = Project::where('tenant_id', $tenantId)
            ->sum('actual_cost');

        $roi = $costs > 0 ? (($revenue - $costs) / $costs) * 100 : 0;

        return [
            'revenue' => $revenue,
            'costs' => $costs,
            'profit' => $revenue - $costs,
            'roi' => $roi,
        ];
    }
}

