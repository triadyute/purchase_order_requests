@extends('layouts.app')
@section('content')
<h4>Purchase order#: PO{{$purchaseOrderRequest->id}}</h4>
<hr>
@include('inc.messages')
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
        <p><strong>Amount requested:</strong>                                    
            @if($purchaseOrderRequest->currency == 'usd')
            &#36;
            @elseif($purchaseOrderRequest->currency == 'gbp')
            &#163;
            @elseif($purchaseOrderRequest->currency == 'eur')
            &#128;
            @endif{{$purchaseOrderRequest->amount}}
        </p>
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
<hr>
<div class="row">
    <div class="col-md-4">
        <p><strong>Manager Approval:</strong><br>
            {{$purchaseOrderRequest->approved_by_manager}} 
            @if($manager)
            {{" - " . $manager->name}}<br>
            on {{\Carbon\Carbon::parse($purchaseOrderRequest->approved_by_manager_on)->toFormattedDateString()}}
            @endif</p>
    </div>
    <div class="col-md-4">
        <p><strong>Senior Manager Approval:</strong><br>
            {{$purchaseOrderRequest->approved_by_senior_manager}} 
            @if($seniorManager)
            {{" - " . $seniorManager->name}}<br>
            on {{\Carbon\Carbon::parse($purchaseOrderRequest->approved_by_senior_manager_on)->toFormattedDateString()}}
            @endif</p>
    </div>
    <div class="col-md-4">
        <p><strong>Admin Approval</strong><br>
            {{$purchaseOrderRequest->approved_by_admin}}
            @if($admin){{" - " . $admin->name}}<br>
            on {{\Carbon\Carbon::parse($purchaseOrderRequest->approved_by_admin_on)->toFormattedDateString()}}
            @endif</p>
    </div>
</div>
@if (Auth::user()->hasManagerRole())
<h4>Manager Approval</h4>
<form method="POST" action="{{route('manager.approve', $purchaseOrderRequest)}}">
    @csrf
    @method('PUT')
    <div class="row">
       <div class="col-md-3">
          <select name="approved_by_manager" class="form-control" id="approved_by_manager" @if($purchaseOrderRequest->approved_by_manager != "Pending") disabled @endif>>
              <option value="Pending" @if($purchaseOrderRequest->approved_by_manager == "Pending") selected disabled @endif>Pending</option>
              <option value="Approved" @if($purchaseOrderRequest->approved_by_manager == "Approved") selected @endif>Approved</option>
              <option value="Declined" @if($purchaseOrderRequest->approved_by_manager == "Declined") selected @endif>Declined</option>
          </select>
        </div>
        @if ($purchaseOrderRequest->approved_by_manager == 'Pending')
            <div class="col-md-3">
                <button class="btn btn-success">Submit</button>
            </div>
        @endif  
    </div>
</form>
@elseif(Auth::user()->hasSeniorManagerRole())
<h4>Senior Manager Approval</h4>
<form method="POST" action="{{route('senior-manager.approve', $purchaseOrderRequest)}}">
    @csrf
    @method('PUT')
    <div class="row">
       <div class="col-md-3">
          <select name="approved_by_senior_manager" class="form-control" id="approved_by_senior_manager" @if($purchaseOrderRequest->approved_by_senior_manager != "Pending") disabled @endif>>
              <option value="Pending" @if($purchaseOrderRequest->approved_by_senior_manager == "Pending") selected disabled @endif>Pending</option>
              <option value="Approved" @if($purchaseOrderRequest->approved_by_senior_manager == "Approved") selected @endif>Approved</option>
              <option value="Declined" @if($purchaseOrderRequest->approved_by_senior_manager == "Declined") selected @endif>Declined</option>
          </select>
        </div>
        @if ($purchaseOrderRequest->approved_by_senior_manager == 'Pending')
            <div class="col-md-3">
                <button class="btn btn-success">Submit</button>
            </div>
        @endif  
    </div>
</form>
@elseif(Auth::user()->hasAdminRole())
<h4>Admin Approval</h4>
<form method="POST" action="{{route('admin.approve', $purchaseOrderRequest)}}">
    @csrf
    @method('PUT')
    <div class="row">
       <div class="col-md-3">
          <select name="approved_by_admin" class="form-control" id="approved_by_admin" @if($purchaseOrderRequest->approved_by_admin != "Pending") disabled @endif>>
              <option value="Pending" @if($purchaseOrderRequest->approved_by_admin == "Pending") selected disabled @endif>Pending</option>
              <option value="Approved" @if($purchaseOrderRequest->approved_by_admin == "Approved") selected @endif>Approved</option>
              <option value="Declined" @if($purchaseOrderRequest->approved_by_admin == "Declined") selected @endif>Declined</option>
          </select>
        </div>
        @if ($purchaseOrderRequest->approved_by_admin == 'Pending')
            <div class="col-md-3">
                <button class="btn btn-success">Submit</button>
            </div>
        @endif  
    </div>
</form>
@endif
@if ((Auth::user()->hasAdminRole() || Auth::user()->hasSuperuserRole()) && $purchaseOrderRequest->approved_by_admin == 'Approved')
    <hr>
    <div class="row">
        <div class="col-md-12">
            <a href="{{route('download.pdf', $purchaseOrderRequest)}}"><button class="btn btn-primary">Download PDF copy</button></a>
        </div>
    </div>
@elseif((Auth::user()->hasuserRole() || Auth::user()->hasManagerRole()|| Auth::user()->hasSeniorManagerRole()) && $purchaseOrderRequest->approved_by_admin == 'Approved')
<hr>
<div class="row">
    <div class="col-md-12">
        <a href="{{route('download.pdf', $purchaseOrderRequest)}}"><button class="btn btn-primary">Download PDF copy</button></a>
    </div>
</div>
@endif
@endsection