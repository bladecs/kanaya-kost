<?php

namespace App\Console\Commands;

use App\Models\PaymentModel;
use App\Models\RoomModels;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Carbon\Carbon;

class GenerateMonthlyPayments extends Command
{
    protected $signature = 'payments:generate';
    protected $description = 'Generate monthly payments for active customer tenants';

    public function handle()
    {
        // 1. Update late payments
        $this->checkLatePayments();

        // 2. Generate new payments
        $this->generateNewPayments();

        $this->info('Monthly payments processed successfully.');
    }

    protected function checkLatePayments()
    {
        $unpaidPayments = PaymentModel::whereIn('status', ['pending', 'late'])
            ->where('periode', '<', now()->startOfMonth())
            ->get();

        foreach ($unpaidPayments as $payment) {
            $payment->update(['status' => 'late']);
            User::where('id', $payment->user_id)
                ->update(['status' => 'non-active']);
        }

        $this->info('Checked '.$unpaidPayments->count().' late payments.');
    }

    protected function generateNewPayments()
    {
        // Get rooms that have active customer tenants
        $roomsWithTenants = RoomModels::whereNotNull('tenant')
            ->with(['user' => function($query) {
                $query->where('status', 'active')
                      ->where('role', 'customer');
            }])
            ->get();

        $newInvoices = 0;

        foreach ($roomsWithTenants as $room) {
            // Skip if room doesn't have valid tenant
            if (!$room->user) {
                continue;
            }

            // Check if payment already exists for this month
            $existingPayment = PaymentModel::where('user_id', $room->tenant)
                ->where('room_id', $room->id)
                ->whereBetween('periode', [
                    now()->startOfMonth(),
                    now()->endOfMonth()
                ])->exists();

            if (!$existingPayment) {
                PaymentModel::create([
                    'id' => 'INV-'.$room->tenant.'-'.now()->format('Ym').'-'.Str::random(4),
                    'user_id' => $room->tenant,
                    'room_id' => $room->id,
                    'amount' => $room->price,
                    'periode' => now()->addMonth(),
                    'status' => 'pending',
                    'payment_proof' => null,
                ]);

                $newInvoices++;
            }
        }

        $this->info('Generated '.$newInvoices.' new invoices.');
    }
}
