@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-6 float-left">
        <h4>
            Departments
        </h4>
    </div>
    <div class="col-md-6">
        <a href="{{route('department.create')}}"><span class="float-right"><button class="btn btn-primary btn-sm" id="viewButton"><i class="fa fa-plus"></i> Add new department</button></span></a>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        @include('inc.messages')
        <table class="table table-striped">
            <thead>
                <tr>
                    <th colspan="2">Department name</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($departments as $department)
                <tr>
                    <td>{{$department->name}}</td>
                    <td class="text-right"><button class="btn btn-primary btn-sm">Edit</button> <button class="btn btn-primary btn-sm">Delete</button></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
    <hr>
@endsection