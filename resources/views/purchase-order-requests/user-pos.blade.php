@extends('layouts.app')
@section('content')
<h4>All purchase order requests for {{$user->name}}</h4>
<hr>
@include('inc.messages')
<span class="small">
<table class="table table-striped" id="myTable">
    <thead>
        <tr>
            <th>Req#</th>
            <th>Category</th>
            <th>Amount</th>
            <th>Request details</th>
            <th>Approval</th>
            <th>Req. Date</th>
            <th>Exp. Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
            @foreach ($purchaseOrderRequests as $po_request)
            <tr>
                <td>
                    @if ($po_request->id < 10)
                    {{"0".$po_request->id}}
                    @else
                    {{$po_request->id}}
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
                <td>{{\Carbon\Carbon::parse($po_request->expected_on)->toFormattedDateString()}}</td>
                <!--<td><button class="btn btn-success btn-sm" id="viewButton">View PO Request</button></td>-->
                <td>
                    <a href="{{route('purchase-order-request.show', $po_request)}}"><button class="btn btn-success btn-sm">View request</button></a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
</span>
@section('scripts')
    <script>
        $('#myTable').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                'copy', 'excel', 'pdf', 'print'
            ],
            order: [[ 0, "desc" ]]
        } );
    </script>
@endsection    
@endsection