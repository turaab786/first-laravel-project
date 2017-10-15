@extends('layouts.admin')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/bootstrap-toggle.min.css') }}">
@endsection
@section('content')
    <h1>replies</h1>
    <table class="table table-hover">
        <thead>
        <tr>
            <th>ID</th>
            <th>Author</th>
            <th>Email</th>
            <th>Body</th>
            <th>Posted At</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($replies as $reply)
            <tr>
                <td>{{ $reply->id }}</td>
                <td>{{ $reply->author }}</td>
                <td>{{ $reply->email }}</td>
                <td>{{ $reply->body }}</td>
                <td>{{ $reply->created_at->diffForHumans() }}</td>
                <td><a href="{{ route('home.post', $reply->post_id) }}" target="_blank">View Post</a> | <input class="status-btn" {{ ($reply->is_active == 0) ? 'checked' : '' }} data-reply-id="{{ $reply->id }}" data-toggle="toggle" data-size="small" data-on="Approve" data-off="un-approve" data-onstyle="success" data-offstyle="danger" type="checkbox" /> | <button class="delete-btn btn btn-danger btn-xs" data-reply-id = "{{$reply->id}}" data-title="Delete" ><span class="glyphicon glyphicon-trash"></span></button></td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="row">
        <div class="col-sm-9"></div>
        <div class="col-sm-3">
            {{ $replies->render()  }}
        </div>
    </div>
@endsection

@section('footer')
    <script src="{{ asset('js/bootstrap-toggle.min.js') }}"></script>
    <script type="text/javascript">
        //Change Status
        $('.status-btn').change(function(){
            var reply_id = $(this).attr('data-reply-id');
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
                            url: '{{ url('/admin/comment/replies/') }}' + '/' + reply_id,
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
            var reply_id = $(this).attr('data-reply-id');

            swal({
                    title: "Are you sure?",
                    text: "You want to delete the reply!",
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
                            url: '{{ url('/admin/comment/replies/') }}' + '/' + reply_id,
                            data: { "_token": "{{ csrf_token() }}" },
                            success:function(data){
                                if(data.success){
                                    swal({
                                        title: "Changed!",
                                        text: "Reply has been deleted!",
                                        type: "success"
                                    },function(){
                                        location.href = "{{ route('admin.comment.replies.show',$comment['id']) }}";
                                    });
                                } else {
                                    swal("Not deleted", "Something went wrong :)", "error");
                                }
                            }
                        });

                    } else {
                        swal("Cancelled", "Your reply is not delted :)", "error");
                    }
                }
            );
        });
    </script>
@endsection