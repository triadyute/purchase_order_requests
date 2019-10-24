<?php

namespace App\Http\Controllers;

use App\PurchaseOrderRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use App\Notifications\RequestReceived;
use App\Mail\ManagerApproval;
use App\Mail\SeniorManagerApproval;
use App\Mail\AdminApproval;
use App\Mail\AdminResponse;
use App\User;
use Illuminate\Http\Request;
use Notification;
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
        $purchaseOrderRequests = PurchaseOrderRequest::orderBy('id', 'DESC')->get();
        if(Gate::allows('view-all-pos', $purchaseOrderRequests)){
            return view('purchase-order-requests.index' , compact('purchaseOrderRequests'));
        }
        elseif(Gate::allows('view-my-staff-pos', $purchaseOrderRequests)){
            $purchaseOrderRequests =  PurchaseOrderRequest::join('users', function($u){$u->on('purchase_order_requests.user_id', '=','users.id');})
            ->where('users.department_id', Auth::user()->department_id)->join('role_user as ru', 'ru.user_id', '=', 'users.id' )
            ->join('roles', function($r){$r->on('roles.id', '=', 'ru.role_id')->where('roles.name', '=', 'User')
            ->orWhere('purchase_order_requests.user_id', '=', Auth::user()->id);})->distinct()->orderBy('id', 'DESC')->get(['purchase_order_requests.*']);
            return view('purchase-order-requests.index', compact('purchaseOrderRequests'));
        }
        elseif(Gate::allows('view-staff-pos', $purchaseOrderRequests)){
            $purchaseOrderRequests = PurchaseOrderRequest::join('users', function($u){$u->on('purchase_order_requests.user_id', '=', 'users.id');})->where('users.department_id', Auth::user()->department_id)->orderBy('id', 'DESC')->get(['purchase_order_requests.*']);
            return view('purchase-order-requests.index', compact('purchaseOrderRequests'));
        }
        else{
            $purchaseOrderRequests = PurchaseOrderRequest::where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->get();
            return view('purchase-order-requests.index', compact('purchaseOrderRequests'));
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

         if(Auth::user()->hasUserRole())
         {
            $purchaseOrderRequest = PurchaseOrderRequest::create($data);
            $purchaseOrderRequest->user_id = Auth::user()->id;
            $purchaseOrderRequest->save();
            $user = Auth::user();
            $managers = User::getManagers(Auth::user()->department->id);
            
            //Send notifications to managers
            $manager_notifications = User::whereHas(
                'roles', function($q){
                    $q->where('name', 'Manager');
            })->where('department_id', Auth::user()->department_id)->get();
            foreach($manager_notifications as $manager){
                $manager->notify(new RequestReceived($user, $purchaseOrderRequest));
            }
            //Send email to managers
            Mail::to($managers)->queue(new ManagerApproval($user, $purchaseOrderRequest));
         }
         elseif(Auth::user()->hasManagerRole())
         {
            $purchaseOrderRequest = PurchaseOrderRequest::create($data);
            $purchaseOrderRequest->user_id = Auth::user()->id;
            $purchaseOrderRequest->manager_id = Auth::user()->id;
            $purchaseOrderRequest->approved_by_manager = 'Approved';
            $purchaseOrderRequest->save();
            $user = Auth::user();
            $senior_managers = User::getSeniorManagers(Auth::user()->department->id);
            Mail::to($senior_managers)->queue(new SeniorManagerApproval($user, $purchaseOrderRequest, ));
         }
         elseif(Auth::user()->hasSeniorManagerRole())
         {
            $purchaseOrderRequest = PurchaseOrderRequest::create($data);
            $purchaseOrderRequest->user_id = Auth::user()->id;
            $purchaseOrderRequest->manager_id = Auth::user()->id;
            $purchaseOrderRequest->approved_by_manager = 'N/A';
            $purchaseOrderRequest->senior_manager_id = Auth::user()->id;
            $purchaseOrderRequest->approved_by_senior_manager = 'Approved';
            $purchaseOrderRequest->save();
            $user = Auth::user();
            $admin = User::getAdmin();
            Mail::to($admin)->queue(new SeniorManagerApproval($user, $purchaseOrderRequest));
         }
         return redirect(route('purchase-order-request.index'))->with('status', 'Purchase order request submitted');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PurchaseOrderRequest  $purchaseOrderRequest
     * @return \Illuminate\Http\Response
     */
    public function show(PurchaseOrderRequest $purchaseOrderRequest)
    {   
        $manager = User::find($purchaseOrderRequest->manager_id);
        $seniorManager = User::find($purchaseOrderRequest->senior_manager_id);
        $admin = User::find($purchaseOrderRequest->admin_id);
        return view('purchase-order-requests.show', compact('purchaseOrderRequest', 'manager', 'seniorManager', 'admin'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PurchaseOrderRequest  $purchaseOrderRequest
     * @return \Illuminate\Http\Response
     */

    public function user_pos(User $user){
        $purchaseOrderRequests = $user->allMyPurchaseOrders();
        return view('purchase-order-requests.user-pos', compact('purchaseOrderRequests', 'user'));
    } 

    public function manager_approval(PurchaseOrderRequest $purchaseOrderRequest, Request $request) 
    {
        $user = $purchaseOrderRequest->user;
        $purchaseOrderRequest->manager_id = Auth::user()->id;
        $purchaseOrderRequest->approved_by_manager = $request->approved_by_manager;
        $purchaseOrderRequest->approved_by_manager_on = now()->format('Y-m-d H:i:s');
        $purchaseOrderRequest->update();
        $senior_managers = User::getSeniorManagers(Auth::user()->department->id);
        Mail::to($senior_managers)->queue(new SeniorManagerApproval($user, $purchaseOrderRequest, ));
        return redirect()->back()->with('status', 'Purchase order request updated');
    }

    public function senior_manager_approval(PurchaseOrderRequest $purchaseOrderRequest, Request $request) 
    {
        $user = $purchaseOrderRequest->user;
        $purchaseOrderRequest->senior_manager_id = Auth::user()->id;
        $purchaseOrderRequest->approved_by_senior_manager = $request->approved_by_senior_manager;
        $purchaseOrderRequest->approved_by_senior_manager_on = now()->format('Y-m-d H:i:s');
        $purchaseOrderRequest->update();
        $admin = User::getAdmin();
        Mail::to($admin)->queue(new AdminApproval($user, $purchaseOrderRequest, ));
        return redirect()->back()->with('status', 'Purchase order request updated');
    }

    public function admin_approval(PurchaseOrderRequest $purchaseOrderRequest, Request $request) 
    {
        $user = $purchaseOrderRequest->user;
        $purchaseOrderRequest->admin_id = Auth::user()->id;
        $purchaseOrderRequest->approved_by_admin = $request->approved_by_admin;
        $purchaseOrderRequest->approved_by_admin_on = now()->format('Y-m-d H:i:s');
        $purchaseOrderRequest->update();
        Mail::to($user)->queue(new AdminResponse($user, $purchaseOrderRequest));
        return redirect()->back()->with('status', 'Purchase order request updated');
    }

    public function download_pdf(PurchaseOrderRequest $purchaseOrderRequest)
    {
        $data = $purchaseOrderRequest;
        //return $data;
        $pdf = PDF::loadView('pdf.purchase_order' , compact('data'));
        return $pdf->download('Purchase_order_'. $purchaseOrderRequest->created_at . '.pdf');
    }
}
