<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\PurchaseOrderRequest;
use App\USer;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $purchase_order_requests = PurchaseOrderRequest::orderBy('id', 'DESC')->get();
        if(Gate::allows('view-all-pos', $purchase_order_requests)){
            return view('home', compact('purchase_order_requests'));

        }
        else{
            $total_requests = Auth::user()->myPurchaseOrders();
            $approved_requests = Auth::user()->myApprovedPurchaseOrders();
            $purchase_order_requests = Auth::user()->myPurchaseOrders();
            return view('home', compact('purchase_order_requests', 'total_requests', 'approved_requests'));
        }
        //return $approved_requests;
        
    }
}
