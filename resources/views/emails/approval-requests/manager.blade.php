@extends('layouts.mail')
@section('content')
    <p><strong>You received a Purchase order request from:</strong></p>
    <p>{{$user->name}}</p>
    <p>Please click <a href="{{route('purchase-order-request.show', $purchase_order_request)}}">here</a> to review.</p>
@endsection