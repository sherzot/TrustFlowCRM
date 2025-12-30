<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Invoice;
use App\Models\Contract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ClientPortalController extends Controller
{
    /**
     * Client Portal login page
     */
    public function login()
    {
        return view('client-portal.login');
    }

    /**
     * Client Portal dashboard
     */
    public function dashboard(Request $request)
    {
        // Token orqali autentifikatsiya (oddiy misol)
        $token = $request->get('token');
        
        if (!$token) {
            return redirect()->route('client-portal.login');
        }

        // Token orqali account ni topish (oddiy misol - production da yaxshiroq autentifikatsiya kerak)
        $account = \App\Models\Account::where('portal_token', $token)->first();
        
        if (!$account) {
            return redirect()->route('client-portal.login')->with('error', 'Invalid token');
        }

        $projects = Project::where('account_id', $account->id)
            ->with(['tasks', 'invoice'])
            ->get();

        $invoices = Invoice::where('account_id', $account->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $contracts = Contract::where('account_id', $account->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('client-portal.dashboard', compact('account', 'projects', 'invoices', 'contracts'));
    }

    /**
     * View project details
     */
    public function project(Request $request, $id)
    {
        $token = $request->get('token');
        $account = \App\Models\Account::where('portal_token', $token)->first();
        
        if (!$account) {
            return redirect()->route('client-portal.login');
        }

        $project = Project::where('id', $id)
            ->where('account_id', $account->id)
            ->with(['tasks', 'invoice', 'deal'])
            ->firstOrFail();

        return view('client-portal.project', compact('project', 'account'));
    }

    /**
     * View invoice
     */
    public function invoice(Request $request, $id)
    {
        $token = $request->get('token');
        $account = \App\Models\Account::where('portal_token', $token)->first();
        
        if (!$account) {
            return redirect()->route('client-portal.login');
        }

        $invoice = Invoice::where('id', $id)
            ->where('account_id', $account->id)
            ->with(['items', 'project'])
            ->firstOrFail();

        return view('client-portal.invoice', compact('invoice', 'account'));
    }

    /**
     * Sign contract
     */
    public function signContract(Request $request, $id)
    {
        $token = $request->get('token');
        $account = \App\Models\Account::where('portal_token', $token)->first();
        
        if (!$account) {
            return redirect()->route('client-portal.login');
        }

        $contract = Contract::where('id', $id)
            ->where('account_id', $account->id)
            ->where('status', 'sent')
            ->firstOrFail();

        if ($request->isMethod('post')) {
            $contract->update([
                'status' => 'signed',
                'signed_at' => now(),
                'signed_by' => $request->input('signer_name'),
                'signature_data' => $request->input('signature'),
            ]);

            return redirect()->route('client-portal.dashboard', ['token' => $token])
                ->with('success', 'Contract signed successfully');
        }

        return view('client-portal.sign-contract', compact('contract', 'account'));
    }
}
