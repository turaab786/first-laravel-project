@extends('layouts.admin')

@section('content')
    @if(Session::has('user_success'))
        <div class="alert alert-success">
            <strong>Success!</strong> {{session('user_update_success')}}
        </div>
    @endif
    <h3>Users</h3>
     <table class="table table-hover">
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
             <td><a href="{{route('admin.users.edit',$user->id)}}" class="btn btn-primary btn-xs" data-title="Edit"><span class="glyphicon glyphicon-pencil"></span></a> | <button class="delete-btn btn btn-danger btn-xs" data-user-id = "{{$user->id}}" data-title="Delete" ><span class="glyphicon glyphicon-trash"></span></button></td>
           </tr>
         @endforeach
         </tbody>
      </table>
      <div class="row">
          <div class="col-sm-9"></div>
          <div class="col-sm-3">
              {{ $users->render()  }}
          </div>
      </div>
@endsection
@section('footer')
    <script type="text/javascript">
        $('.delete-btn').on('click', function(){
            var user_id = $(this).attr('data-user-id');
            swal({
                    title: "Are you sure?",
                    text: "You may be able to recover in future!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel plx!",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function(isConfirm) {

                    if (isConfirm) {
                        $.ajax({
                            type:'POST',
                            method:"DELETE",
                            dataType:"json",
                            url: '{{ url('/admin/users') }}' + '/' + user_id,
                            data: { "_token": "{{ csrf_token() }}" },
                            success:function(data){
                                if(data.success){


                                        swal({
                                            title: "Deleted!",
                                            text: "User has been deleted!",
                                            type: "success"
                                        }, function() {
                                            window.location = "{{route('admin.users.index')}}";
                                        });
                                } else {
                                    swal("Not Deleted", "Something went wrong :)", "error");
                                }
                            }
                        });
                    } else {
                        swal("Cancelled", "Your user data is safe :)", "error");
                    }
                });
        });
    </script>
@endsection