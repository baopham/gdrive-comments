@extends('layout')


@section('content')
<h3>Comments for {{ $file->title }}</h3>

@foreach ($file->comments as $comment)
    <ul class="list-group">
        <li class="list-group-item list-group-item-info">
            <article>
                <span class="label label-default">
                    {{ $comment->context }}
                </span>
                &nbsp;
                {!! $comment->htmlContent !!}
                <p>
                    <small><i class="pull-right">{{ $comment->status }} - created by {{ $comment->author->displayName  }} on {{ $comment->createdDate }}</i></small>
                </p>
            </article>
        </li>

        @if ($comment->replies)

            @foreach ($comment->replies as $reply)
                <li class="list-group-item">
                    {!! $reply->htmlContent !!}
                    <p class="text-info">
                        {{ $reply->author->displayName }} on {{ $reply->createdDate }}
                    </p>
                </li>
            @endforeach

        @endif
    </ul>
@endforeach
@endsection
