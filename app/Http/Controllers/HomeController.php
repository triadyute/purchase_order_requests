<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $purchase_order_requests = PurchaseOrderRequest::where('user_id', Auth::user()->id)->limit(5)->orderBy('id', 'DESC')->get();
        $total_requests = PurchaseOrderRequest::where('user_id', Auth::user()->id)->get();
        $approved_requests = PurchaseOrderRequest::where('approved_by_admin', 'Approved')->get();
        //return $managers;
        return view('home', compact('purchase_order_requests', 'total_requests', 'approved_requests'));
    }
}
