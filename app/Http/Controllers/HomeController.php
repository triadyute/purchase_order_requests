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
        $purchaseOrderRequests = PurchaseOrderRequest::orderBy('id', 'DESC')->limit(5)->get();
        $approvedPurchaseOrderRequests = PurchaseOrderRequest::where('approved_by_admin', 'Approved')->get();
        $declinedPurchaseOrderRequests = PurchaseOrderRequest::where('approved_by_admin', 'Declined')->get();
        if(Gate::allows('view-all-pos', $purchaseOrderRequests)){
            return view('home', compact('purchaseOrderRequests', 'approvedPurchaseOrderRequests', 'declinedPurchaseOrderRequests'));

        }
        else{
            $myApprovedPurchaseOrderRequests = Auth::user()->myApprovedPurchaseOrders();
            $myDeclinedPurchaseOrderRequests = Auth::user()->myDeclinedPurchaseOrders();
            $purchaseOrderRequests = Auth::user()->myPurchaseOrders();
            $allMyPurchaseOrderRequests = Auth::user()->allMyPurchaseOrders();
            return view('home', compact('purchaseOrderRequests', 'allMyPurchaseOrderRequests', 'myApprovedPurchaseOrderRequests', 'myDeclinedPurchaseOrderRequests'));
        }
        //return $approved_requests;
        
    }
}
