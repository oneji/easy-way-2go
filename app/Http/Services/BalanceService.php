<?php

namespace App\Http\Services;

use App\Driver;
use App\Expense;
use App\Order;
use App\OrderStatus;
use App\PaymentStatus;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BalanceService
{
    /**
     * Get all related to the user's balance
     * 
     * @param \Illuminate\Http\Request $request
     */
    public function all(Request $request)
    {
        $user = $request->authUser;
        $transport = null;
        $balance = 0;
        $debts = 0;
        $totalServiceComission = 0;
        
        // Filtering params
        $month = $request->query('month') ? $request->query('month') : Carbon::now()->month;
        $orderId = $request->query('order_id');

        // Get all transport depending on the user role
        if($user->role === 'brigadir') {
            $transport = Driver::join('driver_transport', 'driver_transport.driver_id', 'drivers.id')
                ->join('transports', 'transports.id', 'driver_transport.transport_id')
                ->select('transports.*')
                ->where('drivers.brigadir_id', $user->id)
                ->get();
        } else if($user->role === 'driver') {
            $transport = DB::table('driver_transport')
                ->join('transports', 'transports.id', 'driver_transport.transport_id')
                ->select('transports.*')
                ->whereDriverId($user->id)
                ->get();
        }

        // Get balance, debts
        $balance = $transport->unique()->sum('balance');
        $allDebts = Order::where('payment_status_id', PaymentStatus::getNotPaid()->id)
            ->whereIn('transport_id', $transport->pluck('id'))
            ->get();

        // Get all transactions
        $transactions = Transaction::join('orders', 'orders.id', 'transactions.order_id')
            ->join('payment_methods', 'payment_methods.id', 'transactions.payment_method_id')
            ->join('trips', 'trips.id', 'orders.trip_id')
            ->select(
                'trips.status_id as trip_status_id',
                'orders.trip_id',
                'transactions.id',
                'transactions.order_id',
                'transactions.amount',
                'transactions.type',
                'transactions.date',
                'payment_methods.code as payment_method_code'
            )
            ->whereMonth('transactions.date', $month)
            ->when($orderId, function($query) use ($orderId) {
                $query->where('orders.id', 'like', "%$orderId%");
            })
            ->whereIn('orders.transport_id', $transport->pluck('id'))
            ->get();
        $totalServiceComission = $transactions->where('trip_status_id', OrderStatus::getFinished()->id)->where('type', 'outcome')->sum('amount');
                    
        $firstOrder = $transactions->sortBy('id')->first();

        $weeks = [];
        $week = 1;
        if($firstOrder) {
            $now = Carbon::parse($firstOrder->date);
            $endOfMonth = Carbon::parse($firstOrder->date)->endOfMonth();

            do {
                $endOfWeek = Carbon::parse($now)->addDays(7);
                $formattedNow = $now->format('d.m.Y');
                $formattedEndOfWeek = $endOfWeek->format('d.m.Y');
    
                if(Carbon::parse($now)->addDays(8) >= $endOfMonth) {
                    $datesArray = [$now, $endOfMonth];
                } else {
                    $datesArray = [$now, $endOfWeek];
                }
    
                $filteredTransactions = $transactions->whereBetween('date', $datesArray);
                $totalProfit = $filteredTransactions->where('type', 'income')->sum('amount');
                $serviceComission = $filteredTransactions->where('type', 'outcome')->sum('amount');
                $debts = $allDebts->whereBetween('date', $datesArray)->sum('total_price');
                $expenses = 0;
    
                foreach ($filteredTransactions as $item) {
                    $expenses = Expense::where('trip_id', $item->trip_id)->sum('amount');
                }

                if($filteredTransactions->count() > 0) {
                    $transactionsGroupedByDate = [];
                    $i = Carbon::parse($now);
                    do {
                        if($filteredTransactions->where('date', $i)->count() > 0) {
                            $transactionsGroupedByDate[Carbon::parse($i)->format('d.m.Y')] = $filteredTransactions->where('date', $i)->values();
                        }
    
                        $i->addDay();
                    } while ($i <= $endOfWeek);
        
                    $weeks[$week] = [
                        'from' => $formattedNow,
                        'to' => $formattedEndOfWeek,
                        'total_profit' => $totalProfit,
                        'service_comission' => $serviceComission,
                        'debts' => $debts,
                        'expenses' => $expenses,
                        'clean_profit' => $totalProfit - $serviceComission - $expenses,
                        'transactions' => $transactionsGroupedByDate,
                    ];
                }
    
                // Move the next week
                $week += 1;
                $now->addDays(8);
            } while ($now <= $endOfMonth);
        }
        

        return [
            'balance' => $balance,
            'debts' => $allDebts->sum('total_price'),
            'service_comission' => $totalServiceComission,
            'weeks' => $weeks
        ];
    }
}