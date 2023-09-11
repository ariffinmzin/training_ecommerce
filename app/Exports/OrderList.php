<?php

namespace App\Exports;

use App\Models\Order;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class OrderList implements FromView
{
    public function view(): View
    {
        return view('admin.order_pdf', [
            'orders' => Order::all()
        ]);
    }
}
