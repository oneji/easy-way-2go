<?php

namespace App\Http\Services;

use App\Driver;
use App\Client;
use App\Brigadir;
use App\Expense;
use App\Order;
use App\OrderStatus;
use App\PaymentMethod;
use App\PaymentStatus;
use App\Transaction;
use App\Transport;
use App\Trip;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatsService
{
    /**
     * Get all statistics
     * 
     * @return collection
     */
    public function all()
    {
        return [
            'driversCount' => Driver::all()->count(),
            'clientsCount' => Client::all()->count(),
            'brigadirsCount' => Brigadir::all()->count(),
            'transportsCount' => Transport::all()->count()
        ];
    }

    /**
     * Get total
     * 
     * @param \Illuminate\Http\Request $request
     */
    public function getTotal(Request $request)
    {
        $user = $request->authUser;
        // Filtering params
        $carNumber = $request->query('car_number');
        $from = $request->query('from') ? Carbon::parse($request->query('from')) : Carbon::now();
        $to = $request->query('to') ? Carbon::parse($request->query('to')) : Carbon::parse(Carbon::now())->endOfMonth();
    
        // ***
        $transport = Driver::join('driver_transport', 'driver_transport.driver_id', 'drivers.id')
            ->join('transports', 'transports.id', 'driver_transport.transport_id')
            ->select('transports.*')
            ->where('drivers.brigadir_id', $user->id)
            ->when($carNumber, function($query) use ($carNumber) {
                $query->where('transports.car_number', 'like', "%$carNumber%");
            })
            ->get();
        // Get all debts
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
            ->whereIn('orders.transport_id', $transport->pluck('id'))
            ->get();
                    
        $firstOrder = $transactions->sortBy('id')->first();

        $weeks = [];
        $week = 1;
        if($firstOrder) {
            $now = $from;
            $endOfMonth = $to;

            do {
                $endOfWeek = Carbon::parse($now)->addDays(7);
                $formattedNow = $now->format('d.m.Y');
                $formattedEndOfWeek = $endOfWeek->format('d.m.Y');
    
                if(Carbon::parse($now)->addDays(8) >= $endOfMonth) {
                    $datesArray = [$now->format('Y-m-d'), $endOfMonth->format('Y-m-d')];
                } else {
                    $datesArray = [$now->format('Y-m-d'), $endOfWeek->format('Y-m-d')];
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

                    $weeks[] = [
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
                $now->addDays(8);
            } while ($now <= $endOfMonth);
        }
        

        return $weeks;
    }

    /**
     * Get stats by bus
     * 
     * @param \Illuminate\Http\Request $request
     */
    public function getByBus(Request $request)
    {
        $user = $request->authUser;
        // Filtering params
        $from = $request->query('from');
        $to = $request->query('to');
        $carNumber = $request->query('car_number');

        $transports = Driver::join('driver_transport', 'driver_transport.driver_id', 'drivers.id')
            ->join('transports', 'transports.id', 'driver_transport.transport_id')
            ->select('transports.id', 'transports.car_number')
            ->where('drivers.brigadir_id', $user->id)
            ->when($carNumber, function($query) use ($carNumber) {
                $query->where('car_number', $carNumber);
            })
            ->get()
            ->unique();

        $ordersAndTotalPrice = Transport::join('orders', 'orders.transport_id', 'transports.id')
            ->selectRaw(
                'transports.id,
                count(orders.id) as orders,
                sum(total_price) as total_price'
            )
            ->groupBy([ 'transports.id' ])
            ->first();

        $trips = Transport::join('trips', 'trips.transport_id', 'transports.id')
            ->selectRaw(
                'transports.id,
                count(trips.id) as trips'
            )
            ->groupBy('transports.id')
            ->first();

        foreach ($transports as $transport) {
            if($transport->id === $trips->id) {
                $transport['trips_count'] = $trips->trips;
            }

            if($transport->id === $ordersAndTotalPrice->id) {
                $transport['orders_count'] = $ordersAndTotalPrice->orders;
                $transport['total_price'] = $ordersAndTotalPrice->total_price;
            }

            $transport['expenses'] = Expense::join('trips', 'trips.id', 'expenses.trip_id')
                ->join('transports', 'transports.id', 'trips.transport_id')
                ->select('expenses.*')
                ->where('trips.transport_id', $transport->id)
                ->sum('expenses.amount');

            $transacions = Transaction::join('orders', 'orders.id', 'transactions.order_id')
                ->join('transports', 'transports.id', 'orders.transport_id')
                ->select('transactions.*')
                ->where('orders.transport_id', $transport->id)
                ->get();
            $transport['profit'] = $transacions->where('type', 'income')->sum('amount');
            $transport['comission'] = $transacions->where('type', 'outcome')->sum('amount');
            
            $transport['order_not_paid'] = Order::where('payment_status_id', PaymentStatus::getNotPaid()->id)
                ->where('transport_id', $transport->id)
                ->sum('total_price');
        }

        return $transports;
    }
}