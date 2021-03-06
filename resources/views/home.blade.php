@extends('layouts.app')

@section('content')
<h4>Purchase Order Portal Dashboard</h4>
<hr>
<h5>Employee info</h5>
<div class="row dashboard-details">
    <div class="col-md-4">
        <p><strong>Name:</strong> {{Auth::user()->name}}</p>
        <p><strong>Job title:</strong> {{Auth::user()->job_title}}</p>
        <p><strong>Department:</strong> {{Auth::user()->department->name}}</p>
    </div>
    <div class="col-md-4">
        <p><strong>Email:</strong> {{Auth::user()->email}}</p>
        <p><strong>Rights:</strong> {{Auth::user()->roles->first()->name}}</p>
        <p><strong>Account created:</strong> <span class="req_date">{{\Carbon\Carbon::parse(Auth::user()->created_at)->toFormattedDateString()}}</span></p>
    </div>
    <div class="col-md-4">
        @can('view-all-pos', $purchaseOrderRequests)
            <p><strong>Total requests: </strong>{{count($purchaseOrderRequests)}}</p>
            <p><strong>Approved requests: </strong>{{count($approvedPurchaseOrderRequests)}}</p>
            <p><strong>Declined requests: </strong>{{count($declinedPurchaseOrderRequests)}}</p>
        @else
            <p><strong>Total requests: </strong>{{count($allMyPurchaseOrderRequests)}}</p>
            <p><strong>Approved requests: </strong>{{count($myApprovedPurchaseOrderRequests)}}</p>
            <p><strong>Declined requests: </strong>{{count($myDeclinedPurchaseOrderRequests)}}</p>
        @endcan
    </div>
</div>

<div class="row">
    <div class="col-md-6 float-left">
        <h4>
            @can('view-all-pos', \App\PurchaseOrderRequest::class)
                Recent purchase order requests
            @else
                My recent purchase order requests
            @endcan
        </h4>
    </div>
    <div class="col-md-6">
        @can('view-all-pos', $purchaseOrderRequests)
        <a href="{{route('purchase-order-request.index')}}"><span class="float-right"><button class="btn btn-primary btn-sm" id="viewButton"><i class="fa fa-eye"></i> See all requests</button></span></a>
        @else
        <a href="{{route('user.pos', Auth::user())}}"><span class="float-right"><button class="btn btn-primary btn-sm" id="viewButton"><i class="fa fa-eye"></i> All my requests</button></span></a>
        @endcan
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        @include('inc.messages')
        <table class="table table-striped small">
            <thead>
                <tr>
                    <th scope="col">Req#</th>
                    <th scope="col">Employee</th>
                    <th scope="col">Category</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Request details</th>
                    <th scope="col">Approval</th>
                    <th scope="col">Date</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($purchaseOrderRequests as $po_request)
                    <tr>
                        <th scope="row">
                            @if ($po_request->id < 10)
                            {{"PO0".$po_request->id}}
                            @else
                            {{"PO".$po_request->id}}
                            @endif
                        </td>
                        <td>{{$po_request->user->name}}</td>
                        <td>{{$po_request->category}}</td>
                        <td>
                                @if($po_request->currency == 'usd')
                                &#36;
                                @elseif($po_request->currency == 'gbp')
                                &#163;
                                @elseif($po_request->currency == 'eur')
                                &#128;
                                @endif
                                {{$po_request->amount}}
                        </td>
                        <td>{{Str::limit($po_request->request_details, 70)}}</td>
                        <td>{{ucfirst($po_request->approved_by_admin)}}</td>
                        <td>{{\Carbon\Carbon::parse($po_request->created_at)->toFormattedDateString()}}</td>
                        <td><a href="{{route('purchase-order-request.show', $po_request)}}"><button class="btn btn-success btn-sm" id="viewButton">View Request</button></a></td>
                        <!--<td>                        
                            <form method="GET" action="{{ route('download.pdf', $po_request)}}">
                            @csrf
                            <button class="btn btn-sm" type="submit">Download pdf</button>
                            </form>
                        </td>-->
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">
                            No records found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
