<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Carbon\Carbon;

use App\Models\User;
use App\Models\Product;
use App\Models\Order;

class DashboardController extends Controller
{
    public function dashboard()
    {

        $total_users = User::count();
        $total_products = Product::count();
        $total_orders = Order::count();
        $total_orders_value = Order::sum('total');

        $statuses = [
            0 => 'pending',
            1 => 'approve',
            2 => 'reject',
        ];

        $reports = [];

        foreach($statuses as $key => $status){

            $total_sale_no = Order::where('status', $key)->count();
            $total_sale_val = Order::where('status', $key)->sum('total');

            $reports[$key] = [
                'total_sale_no' => $total_sale_no,
                'total_sale_val' => $total_sale_val,
            ];

        }

        $graph = [];
        $year = date('Y');

        for($i = 1; $i <= 12; $i++){

            $date = Carbon::createFromDate($year, $i, 1);

            $graph[$i]['month'] = $date->format('M');
            $graph[$i]['total'] = Order::whereMonth('created_at', $i)->whereYear('created_at', $year)->sum('total');

        }

        return view('admin.dashboard', compact('total_users','total_products','total_orders','total_orders_value', 'reports','graph'));

        /***
        Order::
            ->where()
            ->whereMonth()
            ->whereYear()
            ->paginate()
            ->all()
            ->first()
            ->orderBy()
            ->whereHas()
            ->count()
            ->sum()
            ->find()
            ->findOrFail()
            ***/

    }
}
