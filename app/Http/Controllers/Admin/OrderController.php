<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\Order;
use App\Exports\OrderList;

use PDF;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = isset($_GET['search']) ? $_GET['search'] : null;
        $status = isset($_GET['status']) ? $_GET['status'] : 'ALL';

        if($search){

            $orders = Order::whereHas('user', function($q) use ($search) {

                $q->where('name', 'LIKE', '%'.$search.'%')
                ->orWhere('email', 'LIKE', '%'.$search.'%')
                ->orWhere('phone', 'LIKE', '%'.$search.'%');

            })->orWhereHas('product', function($q) use ($search) {

                $q->where('name', 'LIKE', '%'.$search.'%')
                ->orWhere('description', 'LIKE', '%'.$search.'%');
                
            })->orderBy('status', 'ASC');

        } else {

            $orders = Order::orderBy('status', 'ASC');

        }

        if($status != 'ALL'){

            $orders = $orders->where('status', $status);
        }

        $orders = $orders->paginate(5);

        return view('admin.order_index', compact('orders','search','status'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        $this->validate($request, [
            'submit' => 'required|in:approve,reject',
        ]);

        if($request['submit'] == 'approve'){
            $order->status = 1;
        } else {
            $order->status = 2;
        }

        $order->save();
        Session()->flash('message', 'Order status has been updated!');
        return redirect()->route('order.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function pdf()
    {
        $orders = Order::all();

        $pdf = PDF::loadView('admin.order_pdf', compact('orders'));
        return $pdf->setPaper('a4', 'landscape')->download('list_order.pdf');
    }

    public function excel()
    {

        return Excel::download(new OrderList, 'order_list.xlsx');

    }
}
