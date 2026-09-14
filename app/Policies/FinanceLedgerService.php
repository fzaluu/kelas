<?php

namespace App\Services;

use App\Models\Finance\FinancialTransaction;
use App\Models\Core\ActivityLog;
use Carbon\Carbon;

class FinanceLedgerService
{
    // Threshold Transaksi Butuh Approval (Rp 200.000)
    protected float $approvalThreshold = 200000.00;

    public function getBalanceSummary(int $classId): array
    {
        $approvedTransactions = FinancialTransaction::where('class_id', $classId)
            ->where('status', 'APPROVED')
            ->get();

        $totalIncome = $approvedTransactions->where('type', 'INCOME')->sum('amount');
        $totalExpense = $approvedTransactions->where('type', 'EXPENSE')->sum('amount');

        return [
            'total_income' => $totalIncome,
            'total_expense' => $totalExpense,
            'current_balance' => $totalIncome - $totalExpense,
        ];
    }

    public function recordTransaction(
        int $classId,
        int $categoryId,
        string $type,
        float $amount,
        string $description,
        int $creatorUserId,
        ?string $transactionDate = null,
        ?string $referenceNo = null
    ): FinancialTransaction {
        $txDate = $transactionDate ? Carbon::parse($transactionDate) : Carbon::now('Asia/Jakarta');

        // Jika transaksi Pengeluaran (EXPENSE) melebihi threshold, status PENDING_APPROVAL
        $requiresApproval = ($type === 'EXPENSE' && $amount > $this->approvalThreshold);
        $status = $requiresApproval ? 'PENDING_APPROVAL' : 'APPROVED';

        $transaction = FinancialTransaction::create([
            'class_id' => $classId,
            'category_id' => $categoryId,
            'type' => $type,
            'amount' => $amount,
            'transaction_date' => $txDate->toDateString(),
            'description' => $description,
            'status' => $status,
            'reference_no' => $referenceNo,
            'created_by' => $creatorUserId,
            'approved_by' => $requiresApproval ? null : $creatorUserId,
            'approved_at' => $requiresApproval ? null : Carbon::now('Asia/Jakarta'),
        ]);

        ActivityLog::create([
            'actor_user_id' => $creatorUserId,
            'action' => 'finance.transaction.create',
            'resource_type' => 'financial_transaction',
            'resource_id' => $transaction->id,
            'result' => $requiresApproval ? 'PENDING_APPROVAL' : 'SUCCESS',
        ]);

        return $transaction;
    }
}