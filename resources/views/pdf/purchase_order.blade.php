@extends('layouts.pdf')
@section('content')

<div>
    <div>
        <p style="margin-left: -1em;">
            <img src="data:image/png;base64,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" height="80" alt="company_logo" />
        </p>
        <h3 style="font-family:sans-serif;">Purchase Order Request</h3>
        <hr>
        <p style="font-family:sans-serif;">
            <strong>PO Request #:</strong>
            {{"PO" . $data->id}}
        </p>
        <p style="font-family:sans-serif;">
            <strong>Requested by:</strong><br>
            {{$data->user->name}}
        </p>
        <p style="font-family:sans-serif;">
            <strong>Job title:</strong><br>
            {{$data->user->job_title}}
        </p>
        <p style="font-family:sans-serif;">
            <strong>Department:</strong><br>
            {{$data->user->department->name}}
        </p>
        <p style="font-family:sans-serif;">
            <strong>Date of request:</strong><br>
            {{\Carbon\Carbon::parse($data->created_at)->toFormattedDateString()}}
        </p>
        <p style="font-family:sans-serif;">
            <strong>Amount requested:</strong><br>
            @if($data->currency == 'usd')
            &#36;
            @elseif($data->currency == 'gbp')
            &#163;
            @elseif($data->currency == 'eur')
            &#128;
            @endif{{$data->amount}}
        </p>
        <p style="font-family:sans-serif;">
            <strong>Category</strong><br>
            {{$data->category}}
        </p>
        <p style="font-family:sans-serif;">
            <strong>Subcategory:</strong><br>
            {{$data->subcategory}}
        </p>
        <p style="font-family:sans-serif;">
            <strong>Details</strong><br>
            {{$data->request_details}}
        </p>
        <p style="font-family:sans-serif;">
            <strong>Expected by</strong><br>
            {{\Carbon\Carbon::parse($data->expected_on)->toFormattedDateString()}}
        </p>
    </div>
</div>
@endsection