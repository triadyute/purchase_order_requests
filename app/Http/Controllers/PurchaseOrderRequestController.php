<?php

namespace App\Http\Controllers;

use App\PurchaseOrderRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
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
        $purchase_order_requests = PurchaseOrderRequest::all();
        if(Gate::allows('view-all-pos', $purchase_order_requests)){
            return view('purchase-order-requests.index' , compact('purchase_order_requests'));
        }
        elseif(Gate::allows('view-my-staff-pos', $purchase_order_requests)){
            $purchase_order_requests =  PurchaseOrderRequest::join('users', function($u){$u->on('purchase_order_requests.user_id', '=','users.id');})
            ->where('users.department_id', Auth::user()->department_id)->join('role_user as ru', 'ru.user_id', '=', 'users.id' )
            ->join('roles', function($r){$r->on('roles.id', '=', 'ru.role_id')->where('roles.name', '=', 'User')
            ->orWhere('purchase_order_requests.user_id', '=', Auth::user()->id);})->distinct()->get(['purchase_order_requests.*']);
            return view('purchase-order-requests.index', compact('purchase_order_requests'));
        }
        elseif(Gate::allows('view-staff-pos', $purchase_order_requests)){
            $purchase_order_requests = PurchaseOrderRequest::join('users', function($u){$u->on('purchase_order_requests.user_id', '=', 'users.id');})->where('users.department_id', Auth::user()->department_id)->get(['purchase_order_requests.*']);
            return view('purchase-order-requests.index', compact('purchase_order_requests'));
        }
        else{
            $purchase_order_requests = PurchaseOrderRequest::where('user_id', Auth::user()->id)->get();
            return view('purchase-order-requests.index', compact('purchase_order_requests'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $managers = User::whereHas('roles', function($q){
        //     $q->where('name', 'Manager');
        // })->get();
        $managers = User::getManagers(Auth::user()->department->id);
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
         $managers = '';
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
