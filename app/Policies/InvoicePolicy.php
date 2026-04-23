<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Invoice;
use App\Models\User;

final class InvoicePolicy extends BasePolicy
{
    protected string $resource = 'invoices';

    public function send(User $user, Invoice $invoice): bool
    {
        return $this->sameTenant($user, $invoice)
            && $user->can('invoices.send')
            && $invoice->status === 'draft';
    }

    public function markPaid(User $user, Invoice $invoice): bool
    {
        return $this->sameTenant($user, $invoice)
            && ($user->can('invoices.markPaid')
                || $user->hasAnyRole(['finance', 'admin', 'super_admin']));
    }

    public function approve(User $user, Invoice $invoice): bool
    {
        return $this->sameTenant($user, $invoice)
            && ($user->can('invoices.approve')
                || $user->hasAnyRole(['admin', 'manager', 'super_admin']));
    }
}
