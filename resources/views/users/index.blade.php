@extends('layouts.app')
@section('content')
<h4>Manage users</h4>
<hr>
@include('inc.messages')
<span class="small">
    <table class="table table-striped" id="myTable">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Dept.</th>
                <th scope="col">Job Title</th>
                <th scope="col">Privileges</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{$user->id}}</td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->department->name}}</td>
                    <td>{{$user->job_title}}</td>
                    <td>{{$user->roles->first()->name}}</td>
                    <td>
                        <a href="{{route('user.show', $user)}}"><button class="btn btn-primary btn-sm"><i class="fa fa-info"></i> View</button></a>
                        <a href="{{route('user.edit', $user)}}"><button class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Edit</button></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</span>
@section('scripts')
    <script>
        $('#myTable').DataTable();
    </script>
@endsection
@endsection