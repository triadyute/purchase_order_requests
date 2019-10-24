@extends('layouts.mail')
@section('content')
    <p>Dear {{$user->name}},</p>
    <p>Thanks for your patience.</p>
    <p>Your purchase order request was {{strtolower($purchaseOrderRequest->approved_by_admin)}} by our Accounts department.</p>
    <p>Please click <a href="{{route('purchase-order-request.show', $purchaseOrderRequest)}}">here</a> to view.</p>
@endsection