@extends('layouts.admin')

@section('content')
    <h3>Users</h3>
     <table class="table">
         <thead>
           <tr>
             <th>ID</th>
             <th>Photo</th>
             <th>name</th>
             <th>Email</th>
             <th>Role</th>
             <th>Status</th>
             <th>Create At</th>
             <th>Update At</th>
             <th>Action</th>
           </tr>
         </thead>
         <tbody>
         @foreach($users as $user)
           <tr>
             <td>{{ $user->id }}</td>
             <td><img height="50" width="50" src="{{ ($user->photo) ? $user->photo->file : "/images/400x400.png" }}" alt="Photo Not Found"/></td>
             <td>{{ $user->name }}</td>
             <td>{{ $user->email }}</td>
             <td>{{ $user->role->name }}</td>
             <td>{{ ($user->is_active == 1) ? "Active" : "Not Active" }}</td>
             <td>{{ $user->created_at->diffForHumans() }}</td>
             <td>{{ $user->updated_at->diffForHumans() }}</td>
             <td><a href="{{route('admin.users.edit',$user->id)}}" class="btn btn-primary btn-xs" data-title="Edit"><span class="glyphicon glyphicon-pencil"></span></a> | <button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete" ><span class="glyphicon glyphicon-trash"></span></button></td>
           </tr>
         @endforeach
         </tbody>
      </table>
@endsection