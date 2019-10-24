@extends('layouts.mail')
@section('content')
    <p>Dear Admin,</p>
    <p><strong>You received a Purchase order request from:</strong></p>
    <p>{{$user->name}}</p>
    <p>Please click <a href="{{route('purchase-order-request.show', $purchaseOrderRequest)}}">here</a> to review.</p>
@endsection