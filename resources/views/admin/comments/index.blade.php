@extends('layouts.admin')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/bootstrap-toggle.min.css') }}">
@endsection
@section('content')
    <h1>Comments</h1>
     <table class="table table-hover">
         <thead>
           <tr>
             <th>ID</th>
             <th>Athor</th>
             <th>Email</th>
             <th>Body</th>
             <th>Replies</th>
             <th>Posted At</th>
             <th>Action</th>
           </tr>
         </thead>
         <tbody>
         @foreach($comments as $comment)
           <tr>
             <td>{{ $comment->id }}</td>
             <td>{{ $comment->author }}</td>
             <td>{{ $comment->email }}</td>
             <td>{{ $comment->body }}</td>
             <td><a href="{{ route('admin.comment.replies.show', $comment->id) }}" target="_blank">View Replies</a> </td>
             <td>{{ $comment->created_at->diffForHumans() }}</td>
             <td><a href="{{ route('home.post', $comment->post_id) }}" target="_blank">View Post</a> | <input class="status-btn" {{ ($comment->is_active == 0) ? 'checked' : '' }} data-comment-id="{{ $comment->id }}" data-toggle="toggle" data-size="small" data-on="Approve" data-off="un-approve" data-onstyle="success" data-offstyle="danger" type="checkbox" /> | <button class="delete-btn btn btn-danger btn-xs" data-comment-id = "{{$comment->id}}" data-title="Delete" ><span class="glyphicon glyphicon-trash"></span></button></td>
           </tr>
         @endforeach
         </tbody>
      </table>
    <div class="row">
        <div class="col-sm-9"></div>
        <div class="col-sm-3">
            {{ $comments->render()  }}
        </div>
    </div>
@endsection

@section('footer')
    <script src="{{ asset('js/bootstrap-toggle.min.js') }}"></script>
    <script type="text/javascript">
        //Change Status
        $('.status-btn').change(function(){
            var comment_id = $(this).attr('data-comment-id');
            var is_active = 1;

            if ($(this).is(':checked')) {
                is_active = 0;
            }
            swal({
                    title: "Are you sure?",
                    text: "You you want to change the status!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel plx!",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function(isConfirm) {
                    if (isConfirm) {
                        $.ajax({
                            type:'POST',
                            method:"PATCH",
                            dataType:"json",
                            url: '{{ url('/admin/comments') }}' + '/' + comment_id,
                            data: { "_token": "{{ csrf_token() }}","is_active":is_active  },
                            success:function(data){
                                if(data.success){
                                    swal({
                                        title: "Changed!",
                                        text: "Status has been changed!",
                                        type: "success"
                                    });
                                } else {
                                    swal("Not changed", "Something went wrong :)", "error");
                                }
                            }
                        });

                    } else {
                            $('#status-btn').bootstrapToggle('toggle');
                            swal("Cancelled", "You did not changed the status :)", "error");
                        }
                }
            );
        });

        //delete comment

        $('.delete-btn').click(function(){
            var comment_id = $(this).attr('data-comment-id');

            swal({
                    title: "Are you sure?",
                    text: "You you want to delete the comment!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel please!",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function(isConfirm) {
                    if (isConfirm) {
                        $.ajax({
                            type:'POST',
                            method:"DELETE",
                            dataType:"json",
                            url: '{{ url('/admin/comments') }}' + '/' + comment_id,
                            data: { "_token": "{{ csrf_token() }}" },
                            success:function(data){
                                if(data.success){
                                    swal({
                                        title: "Changed!",
                                        text: "Comment has been deleted!",
                                        type: "success"
                                    },function(){
                                        location.href = "{{ route('admin.comments.index') }}";
                                    });
                                } else {
                                    swal("Not deleted", "Something went wrong :)", "error");
                                }
                            }
                        });

                    } else {
                        swal("Cancelled", "Your comment is not delted :)", "error");
                    }
                }
            );
        });
    </script>
@endsection