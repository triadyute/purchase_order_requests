@extends('layouts.app')
@section('content')
<h4>Purchase order#: PO{{$purchaseOrderRequest->id}}</h4>
<hr>
<div class="row request-details">
    <div class="col-md-4">
        <p><strong>Name:</strong> {{$purchaseOrderRequest->user->name}}</p>
        <p><strong>Job title:</strong> {{$purchaseOrderRequest->user->job_title}}</p>
        <p><strong>Department:</strong> {{$purchaseOrderRequest->user->department->name}}</p>
    </div>
    <div class="col-md-4">
        <p><strong>Request made on:</strong> <span class="req_date">{{\Carbon\Carbon::parse($purchaseOrderRequest->created_at)->toFormattedDateString()}}</span></p>
        <p><strong>Category:</strong> {{$purchaseOrderRequest->category}}</p>
        <p><strong>Subcategory:</strong> {{$purchaseOrderRequest->subcategory}}</p>
    </div>
    <div class="col-md-4">
        <p><strong>Amount requested:</strong> {{$purchaseOrderRequest->amount}}</p>
        <p><strong>Funds expected by:</strong> {{\Carbon\Carbon::parse($purchaseOrderRequest->expected_on)->toFormattedDateString()}}</p>
        <p><strong>Admin approval:</strong> {{$purchaseOrderRequest->approved_by_admin}}</p>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <strong>Details</strong><br>
        <p>{{$purchaseOrderRequest->request_details}}</p>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <a href="{{route('download.pdf', $purchaseOrderRequest)}}"><button class="btn btn-primary">Download PDF copy</button></a>
    </div>
</div>
@endsection