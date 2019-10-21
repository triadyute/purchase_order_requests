<?php

namespace App\Http\Controllers;

use App\PurchaseOrderRequest;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Http\Request;
use PDF;

class PurchaseOrderRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $purchase_order_requests = PurchaseOrderRequest::where('user_id', Auth::user()->id)->get();
        return view('purchase-order-requests.index' , compact('purchase_order_requests'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $managers = User::whereHas('roles', function($q){
            $q->where('name', 'Manager');
        })->get();

        //return $managers[0];
        return view('purchase-order-requests.create', compact('managers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd(request()->all());
        $data = request()->validate([        
            'category' => 'nullable|string|max:255',
            'subcategory' => 'nullable|string|max:255',
            'request_details' => 'nullable|string',
            'currency' => 'nullable|string|max:255',
            'amount' => 'nullable|integer',
            'expected_on' => 'date',
         ]);
         //return $data;

         $purchase_order_request = PurchaseOrderRequest::create($data);
         $purchase_order_request->user_id = Auth::user()->id;
         $purchase_order_request->save();
         return redirect(route('home'))->with('status', 'Purchase order request submitted');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PurchaseOrderRequest  $purchaseOrderRequest
     * @return \Illuminate\Http\Response
     */
    public function show(PurchaseOrderRequest $purchaseOrderRequest)
    {
        return view('purchase-order-requests.show', compact('purchaseOrderRequest'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PurchaseOrderRequest  $purchaseOrderRequest
     * @return \Illuminate\Http\Response
     */
    public function edit(PurchaseOrderRequest $purchaseOrderRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PurchaseOrderRequest  $purchaseOrderRequest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PurchaseOrderRequest $purchaseOrderRequest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PurchaseOrderRequest  $purchaseOrderRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy(PurchaseOrderRequest $purchaseOrderRequest)
    {
        //
    }

    public function download_pdf(PurchaseOrderRequest $purchase_order_request)
    {
        $data = $purchase_order_request;

        //return $data;
        $pdf = PDF::loadView('pdf.purchase_order' , compact('data'));
        return $pdf->download('purchase_order.pdf');
    }
}
