@extends('layouts.app')

@section('content')
    <h4>Add new department</h4>
    <hr>
    @include('inc.messages')
    <form method="POST" action="{{route('department.store')}}">
        @csrf
        <div class="row">
            <div class="form-group col-md-3">
            <label for="reason_for_request">Department Name</label>
            <input class="form-control" name="name" id="name" rows="3">
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <button class="btn btn-primary">Save department</button>
            </div>
        </div>
    </form>
@endsection