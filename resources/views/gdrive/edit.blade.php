@extends('layout')


@section('content')
<form action="/gdrive/files/{{ $file->id }}" method="POST">
    <input type="hidden" name="_method" value="PUT">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    <div class="form-group">
        <label for="fileName">File Nickname</label>
        <input type="text" class="form-control" name="fileName" placeholder="Easy name to remember" value="{{ $file->name }}">
    </div>

    <button type="submit" class="btn btn-default">Save</button>
</form>
@endsection
