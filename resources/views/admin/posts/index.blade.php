@extends('layouts.admin')

@section('content')
    @if(Session::has('post_success'))
        <div class="alert alert-success">
            <strong>Success!</strong> {{session('post_success')}}
        </div>
    @endif
    <h3>Posts</h3>
    <table class="table table-hover">
        <thead>
        <tr>
            <th>ID</th>
            <th>User</th>
            <th>Category</th>
            <th>Photo</th>
            <th>Title</th>
            <th>Comments</th>
            <th>Created</th>
            <th>Updated</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($posts as $post)
            <tr>
                <td>{{ $post->id }}</td>
                <td>{{ $post->user->name }}</td>
                <td>{{ $post->category->name }}</td>
                <td><img height="50" width="50" src="{{ ($post->photo) ? $post->photo->file : "/images/400x400.png" }}"/></td>
                <td>{{ $post->title }}</td>
                <td><a href="{{route('admin.comments.show',$post->id)}}">View Comments</a></td>
                <td>{{ $post->created_at->diffForHumans() }}</td>
                <td>{{ $post->updated_at->diffForHumans() }}</td>
                <td><a href="{{route('admin.posts.edit',$post->id)}}" class="btn btn-primary btn-xs" data-title="Edit"><span class="glyphicon glyphicon-pencil"></span></a> | <a href="{{route('home.post',$post->id)}}" target="_blank" class="btn btn-primary btn-xs" data-title="Edit"><span class="glyphicon glyphicon-eye-open"></span></a> | <button class="delete-btn btn btn-danger btn-xs" data-post-id = "{{$post->id}}" data-title="Delete" ><span class="glyphicon glyphicon-trash"></span></button></td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="row">
        <div class="col-sm-9"></div>
        <div class="col-sm-3">
            {{ $posts->render()  }}
        </div>
    </div>
@endsection
@section('footer')
    <script type="text/javascript">
        $('.delete-btn').on('click', function(){
            var post_id = $(this).attr('data-post-id');
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
                            url: '{{ url('/admin/posts') }}' + '/' + post_id,
                            data: { "_token": "{{ csrf_token() }}" },
                            success:function(data){
                                if(data.success){


                                        swal({
                                            title: "Deleted!",
                                            text: "Post has been deleted!",
                                            type: "success"
                                        }, function() {
                                            window.location = "{{route('admin.posts.index')}}";
                                        });
                                } else {
                                    swal("Not Deleted", "Something went wrong :)", "error");
                                }
                            }
                        });
                    } else {
                        swal("Cancelled", "Your post data is safe :)", "error");
                    }
                });
        });
    </script>
@endsection