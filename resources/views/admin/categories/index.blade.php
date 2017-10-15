@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-sm-6">
            @if(Session::has('category_create_success'))
                <div class="alert alert-success">
                    <strong>Success!</strong> {{session('category_create_success')}}
                </div>
            @endif
            {!! Form::open(['method'=>'POST', 'action'=>'AdminCategoriesController@store']) !!}
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                {!! Form::label('name','Category Name:') !!}
                {!! Form::text('name',null,['class'=>'form-control']) !!}
                @if ($errors->has('name'))
                    <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
                @endif
            </div>

            <div class="form-group">
                {!! Form::submit('Create Category',['class'=>'btn btn-primary']) !!}
            </div>
            {!! Form::close() !!}
        </div>
        <div class="col-sm-6">
            @if(Session::has('category_update_success'))
                <div class="alert alert-success">
                    <strong>Success!</strong> {{session('category_update_success')}}
                </div>
            @endif
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Category Name</th>
                    <th>Created</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->created_at->diffForHumans() }}</td>
                        <td><button data-toggle="modal" data-target="#update-category" data-category-id="{{$category->id}}" class="update-btn btn btn-primary btn-xs" data-title="Edit"><span class="glyphicon glyphicon-pencil"></span></button> | <button class="delete-btn btn btn-danger btn-xs" data-category-id = "{{$category->id}}" data-title="Delete" ><span class="glyphicon glyphicon-trash"></span></button></td>

                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="row">
                <div class="col-sm-12">
                    {{ $categories->render()  }}
                </div>
            </div>
        </div>
    </div>
    <div id="update-category" class="modal fade" role="dialog">

    </div>
@endsection

@section('footer')
    <script type="text/javascript">
        $('.update-btn').on('click', function(){
            $('#update-category').children().remove();
            var category_id = $(this).attr('data-category-id');
            $.ajax({
                url: '{{ url('/admin/categories') }}' + '/' + category_id + '/edit',
                data: { "_token": "{{ csrf_token() }}" },
                success:function(data){
                    $('#update-category').append(data);
                }
            });
            //alert(category_id);
            //return false;
        });
        $('.delete-btn').on('click', function(){
            var category_id = $(this).attr('data-category-id');
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
                            url: '{{ url('/admin/categories') }}' + '/' + category_id,
                            data: { "_token": "{{ csrf_token() }}" },
                            success:function(data){
                                if(data.success){

                                    setTimeout(function() {
                                        swal({
                                            title: "Deleted!",
                                            text: "Category has been deleted!",
                                            type: "success"
                                        }, function() {
                                            window.location = "{{route('admin.categories.index')}}";
                                        });
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