<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Update Category</h4>
        </div>
        <div class="modal-body">
            {!! Form::model($category,['method'=>'PATCH', 'action'=>['AdminCategoriesController@update',$category->id]]) !!}
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
                {!! Form::submit('Update Category',['class'=>'btn btn-primary']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>