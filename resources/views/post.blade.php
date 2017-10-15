@extends('layouts.blog-post')

@section('content')

    <!-- Blog Post Content Column -->
    <div class="col-lg-8">

        <!-- Blog Post -->

        <!-- Title -->
        <h1>{{ $post->title }}</h1>

        <!-- Author -->
        <p class="lead">
            by <a href="#">{{ $post->user->name }}</a>
        </p>

        <hr>

        <!-- Date/Time -->
        <p><span class="glyphicon glyphicon-time"></span> Posted {{ $post->created_at->diffForHumans() }}</p>

        <hr>

        <!-- Preview Image -->
        <img class="img-responsive" src="{{ $post->photo->file }}" alt="">

        <hr>

        <!-- Post Content -->
        <p class="lead">Description</p>
        {!! $post->body !!}

        <hr>

        <!-- Blog Comments -->

        <!-- Comments Form -->
        @if(Session::has('comment_success'))
            <div class="alert alert-success">
                <strong>Success!</strong> {{ session('comment_success') }}
            </div>
        @endif
        @if(Auth::check())
        <div class="well">
            <h4>Leave a Comment:</h4>
            {!! Form::open(['method'=>'POST', 'action'=>'PostCommentsController@store']) !!}
                <input type="hidden" name="post_id" value="{{ $post->id }}">
                <div class="form-group">
                     {!! Form::textarea('body',null,['class'=>'form-control','rows'=>3]) !!}
                </div>

                <div class="form-group">
                     {!! Form::submit('Submit',['class'=>'btn btn-primary']) !!}
                </div>
            {!! Form::close() !!}
        </div>
        @endif
        <hr>

        <!-- Posted Comments -->

         <!-- Comment -->
        @foreach( $comments as $comment )
            @if($comment->is_active == 1)
        <div class="media">
            <a class="pull-left" href="#">
                <img height="50" width="50" class="media-object" src="{{ Auth::user()->gravatar }}" alt="">
            </a>
            <div class="media-body">
                <h4 class="media-heading">{{ $comment->author }}
                    <small>{{ $comment->created_at->diffForHumans() }}</small>
                </h4>
                {{ $comment->body }}
                <br />
                <a href="javascript:anchorScr()" data-comment-id="{{ $comment->id }}" class="reply">Reply</a>

                <!-- Nested Comment -->
                @foreach($comment->replies as $reply)
                    @if($reply->is_active)
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" height="50" width="50" src="{{ Auth::user()->gravatar }}" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading">{{ $reply->author }}
                            <small>{{ $reply->created_at->diffForHumans() }}</small>
                        </h4>
                        {{ $reply->body }}
                    </div>
                </div>
                    @endif
                @endforeach
                <form method="POST" action="{{ route('admin.comment.replies.store') }}" id="reply-{{ $comment->id }}">
                    <input type="hidden" name="comment_id" value="{{ $comment->id }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                </form>
                <!-- End Nested Comment -->
            </div>
        </div>
            @endif
       @endforeach

    </div>

@endsection

@section('scripts')
    <script type="text/javascript">
        $('.reply').click(function(){
            var comment_id = $(this).attr('data-comment-id');
            var html = '';
            html += '<div class="comment-reply">';
            html += '<div class="form-group">';
            html += '<textarea name="body" rows="1" placeholder="Write Reply..." class="form-control form-rounded"></textarea>';
            html += '</div>';
            html += '<div class="form-group">';
            html += '<input class="btn btn-primary" value="Submit" type="submit">';
            html += '</div>';
            html += '</div>';
            $('#reply-' + comment_id).append(html);
        });
    </script>
@endsection