@extends('layouts.app')
@section('content')
<h4>
    @if (Auth::user()->id == $user->id)
    My profile
    @else
    {{$user->name . "'s"}} profile
    @endif
</h4>
<hr>
@include('inc.messages')
<div class="row dashboard-details">
    <div class="col-md-2">
        <img src="{{asset('/img/avatar.png')}}" height="150" width="150" alt="">
    </div>
    <div class="col-md-3">
        <p><strong>Name: </strong> {{$user->name}}</p>
        <p><strong>Department:</strong> {{$user->department->name}}</p>
        <p><strong>Job Title:</strong> {{$user->job_title}}</p>
        <p><strong>Account created:</strong> {{\Carbon\Carbon::parse($user->created_at)->toFormattedDateString()}}</p>
    </div>
    <div class="col-md-3">
        <p><strong>Email:</strong> {{$user->email}}</p>
        <p><strong>Role:</strong> {{$user->roles->first()->name}}</p>
        <p><strong>Reports to: </strong>
        @if ($user->hasAdminRole() || $user->hasSuperuserRole())
            N/A
        @else
            @foreach ($managers as $manager)
                {{$manager->name}}
            @endforeach  
        @endif
        </p>
        @if(Auth::user()->id == $user->id || Auth::user()->hasSuperuserRole())
        <a href="{{route('user.edit', $user)}}"><button class="btn btn-primary btn-sm">Edit profile</button></a>
        @endif
    </div>
</div>
    <h4>
            @if (Auth::user()->id == $user->id)
                My recent purchase order requests
            @else
                {{$user->name . "'s"}} recent purchase order requests
            @endif
    </h4>
<div class="row">
        <div class="col-md-12">
            <table class="table table-striped small">
                <thead>
                    <tr>
                        <th scope="col">Req#</th>
                        <th scope="col">Category</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Request details</th>
                        <th scope="col">Approval</th>
                        <th scope="col">Date</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($purchase_order_requests as $po_request)
                        <tr>
                            <th scope="row">
                                @if ($po_request->id < 10)
                                {{"PO0".$po_request->id}}
                                @else
                                {{"PO".$po_request->id}}
                                @endif
                            </td>
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
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection