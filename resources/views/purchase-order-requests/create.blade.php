@extends('layouts.app')

@section('content')
<h4>New Purchase Order Request</h4>
<hr>
@include('inc.messages')
    <form method="POST" action="/purchase-order-request">
        <div class="row">
        {{ csrf_field() }}
        <div class="form-group col-md-3">
            <h6>Submitted by</h6>
            <p>{{Auth::user()->name}}</p>
        </div>
        <div class="form-group col-md-3">
            <h6>Department</h6>
            <p>{{Auth::user()->department->name}}</p>
        </div>
        <div class="form-group col-md-3">
            <h6>Requested on</h6>
            <p class="req_date">{{\Carbon\Carbon::now()->toFormattedDateString()}}</p>
        </div>
        <div class="form-group col-md-3">

            <h6>Line Manager(s)</h6>       
            <ul class="list-unstyled list-inline">
                @foreach ($managers as $manager)
                {{$manager->name}}
                @endforeach
            </ul>

        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-6 service-small">
            <label for="category">Category</label>
            <select id="groups" name="category" class="form-control" required>
                <option selected disabled>Select category</option>
                <option value='training'>Training and exams</option>
                <option value='telephone expenses'>Telephone Expenses</option>
                <option value='travel'>Travel</option>
                <option value='insurance'>Insurance</option>
                <option value='office'>Office Expenses</option>
                <option value='entertainment'>Entertainment</option>
            <select>
        </div>
        <div class="form-group col-md-6 service-small">
            <label for="subcategory">Subcategory</label>
            <select id="sub_groups" name="subcategory" class="form-control">
                <option data-group='SHOW' value='0'>Select subcategory</option>
                <option data-group='training' value='Training'>Training</option>
                <option data-group='training' value='Exams'>Exams</option>
                <option data-group='telephone expenses' value='Mobile'>Mobile</option>
                <option data-group='travel' value='Hotel Accomodations'>Hotel Accomodations</option>
                <option data-group='travel' value='Cars'>Cars</option>
                <option data-group='travel' value='Fuel'>Fuel</option>
                <option data-group='travel' value='Flight'>Flight/Travel</option>
                <option data-group='insurance' value='Medical Insurance'>Medical Insurance</option>
                <option data-group='insurance' value='Business Insurance'>Business Insurance</option>
                <option data-group='entertainment' value='Entertainment'>Customer entertainment</option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-12">
        <label for="reason_for_request">Details(reason for request)</label>
        <textarea class="form-control" name="request_details" id="request_details" rows="3"></textarea>
        </textarea>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-2 service-small">
            <label for="curremcy">Currency</label>
            <select class="form-control" name="currency" id="currency" required>
                <!--<option value="usd" selected disabled>Select currency</option>-->
                <option value="usd">USD</option>
                <option value="gbp">GBP</option>
                <option value="gbp">EUR</option>
            </select>
        </div>
        <div class="form-group col-md-2">
            <label for="amount">Amount</label>
            <input type="text" class="form-control" id="amount_requested" name="amount" placeholder="Required amount" required />
        </div>
        <div class="form-group col-md-3">
        <label for="date_expected">Expected Date</label>
        <!--<input class="form-control" type="text" name="date_expected" id='datepicker' placeholder="Click the calendar"/>-->
        <input type="text" class="form-control datepicker" name="expected_on" id="datepicker" placeholder="Select from calendar" required>
        </div>
        <div class="form-group col-md-3" id="pobutton">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
    </form>
@endsection