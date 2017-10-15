@extends('layouts.admin')

@section('content')
    @if(Session::has('media_success'))
        <!--suppress ALL -->
        <div class="alert alert-success">
            <strong>Success!</strong> {{session('media_success')}}
        </div>
    @endif
    @if(Session::has('media_unsuccess'))
        <div class="alert alert-danger">
            <strong>Please!</strong> {{session('media_unsuccess')}}
        </div>
    @endif
    <button id="delete-btn" class="text-right delete-btn btn btn-danger btn-xs" data-title="Delete" ><span class="glyphicon glyphicon-trash"></span></button>
    {!! Form::open(['method'=>'POST', 'action'=>'AdminMediaController@delete','id'=>"medias-form"]) !!}
    <h1>Medias</h1>
    <table class="table table-hover">
        <thead>
        <tr>
            <th><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></th>
            <th>ID</th>
            <th>Media</th>
            <th>Crated At</th>
        </tr>
        </thead>
        <tbody>
        @foreach( $photos as $photo )
            <tr>
                <td><input type="checkbox" name="selected[]" value="{{ $photo->id }}"/></td>
                <td>{{ $photo->id }}</td>
                <td><img height="50" width="50" src="{{ $photo->file }}" alt="No Media Found"></td>
                <td>{{ $photo->created_at->diffForHumans() }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {!! Form::close() !!}

    <div class="row">
        <div class="col-sm-9"></div>
        <div class="col-sm-3">
            {{ $photos->render()  }}
        </div>
    </div>
@endsection

@section('footer')
    <script type="text/javascript">
        $('#delete-btn').click(function(){
            var selected = false;
             $("input[name='selected[]']:checked").each( function () {
                 if($(this).val() != 0) {
                    selected = true;
                 }
            });
             if(!selected){
                 swal('Warning!','Please select media to delete','warning');
                 return false;
             }
            swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover data!",
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
                        swal({title:"Deleted!", text:"Your data has been deleted.", type:"success"},function(){
                            $('#medias-form').submit();
                        });

                    } else {
                        swal("Cancelled", "Your imaginary file is safe :)", "error");
                    }
                }
            );
        });
    </script>
@endsection