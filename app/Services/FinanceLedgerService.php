<?php

namespace App\Services;

use App\Models\Finance\FinancialTransaction;
use App\Models\Core\ActivityLog;
use Carbon\Carbon;

class FinanceLedgerService
{
    /**
     * Hitung Total Pemasukan, Pengeluaran, dan Saldo Kas Aktual secara Dinamis
     */
    public function getBalanceSummary(int $classId): array
    {
        $approvedTransactions = FinancialTransaction::where('class_id', $classId)
            ->where('status', 'APPROVED')
            ->get();

        $totalIncome = $approvedTransactions->where('type', 'INCOME')->sum('amount');
        $totalExpense = $approvedTransactions->where('type', 'EXPENSE')->sum('amount');
        $currentBalance = $totalIncome - $totalExpense;

        return [
            'total_income' => $totalIncome,
            'total_expense' => $totalExpense,
            'current_balance' => $currentBalance,
        ];
    }

    /**
     * Catat Transaksi Keuangan Baru (Pemasukan / Pengeluaran)
     */
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

        $transaction = FinancialTransaction::create([
            'class_id' => $classId,
            'category_id' => $categoryId,
            'type' => $type,
            'amount' => $amount,
            'transaction_date' => $txDate->toDateString(),
            'description' => $description,
            'status' => 'APPROVED', // Direct approved untuk Bendahara / Wali
            'reference_no' => $referenceNo,
            'created_by' => $creatorUserId,
            'approved_by' => $creatorUserId,
            'approved_at' => Carbon::now('Asia/Jakarta'),
        ]);

        // Audit Log
        ActivityLog::create([
            'actor_user_id' => $creatorUserId,
            'action' => 'finance.transaction.create',
            'resource_type' => 'financial_transaction',
            'resource_id' => $transaction->id,
            'result' => 'SUCCESS',
        ]);

        return $transaction;
    }

    /**
     * Batalkan Transaksi (Tanpa Hard-Delete)
     */
    public function cancelTransaction(int $transactionId, string $reason, int $actorUserId): FinancialTransaction
    {
        $transaction = FinancialTransaction::findOrFail($transactionId);

        $beforeState = $transaction->toArray();

        $transaction->update([
            'status' => 'CANCELLED',
            'cancellation_reason' => $reason,
        ]);

        // Audit Log
        ActivityLog::create([
            'actor_user_id' => $actorUserId,
            'action' => 'finance.transaction.cancel',
            'resource_type' => 'financial_transaction',
            'resource_id' => $transaction->id,
            'before' => $beforeState,
            'after' => $transaction->toArray(),
            'result' => 'SUCCESS',
        ]);

        return $transaction;
    }
}