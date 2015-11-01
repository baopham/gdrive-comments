@extends('layout')


@section('content')
<h3>Get Comments</h3>

<form action="/gdrive/get-comments" method="POST">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    <div class="form-group">
        <label for="fileId">File Id</label>
        <input required="required" type="text" class="form-control" name="fileId" placeholder="File ID">
    </div>

    <div class="checkbox">
        <label>
            <input type="checkbox" name="save"> Save this file
        </label>
    </div>

    <div class="form-group file-nickname hide">
        <label for="fileName">File Nickname</label>
        <input type="text" class="form-control" name="fileName" placeholder="Easy name to remember">
        <p class="help-block">Put in a nickname for this file if you want to save it for later use</p>
    </div>

    <button type="submit" class="btn btn-default">Get comments</button>
</form>

<hr>

@if (count($files) > 0)
<h3>All saved files</h3>
@endif

<ul class="list-group">
    @foreach ($files as $file)
        <li class="list-group-item">
            <a href="/gdrive/files/{{ $file->id }}">
                {{ $file->name }}
            </a>

            <a href="/gdrive/files/{{ $file->id }}"
               data-method="delete" data-token="{{ csrf_token() }}"
               data-confirm="Are you sure?" class="text-danger pull-right">
                <span class="glyphicon glyphicon-remove"></span>
            </a>

            <a href="/gdrive/files/{{ $file->id }}/edit" class="pull-right m-r-sm">
                <span class="glyphicon glyphicon-edit"></span>
            </a>
        </li>
    @endforeach
</ul>

@endsection
