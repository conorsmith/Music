@extends('layouts.admin')

@section('content')
    @if(Session::has('success'))
        <div class="alert alert-success">{{ Session::get('success') }}</div>
    @endif

    <form class="form-horizontal" method="POST" action="/album/{{ $album->id }}">
        {{ method_field("PUT") }}

        {{ csrf_field() }}

        <div class="form-group">
            <label class="col-sm-2 control-label">Artist</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="artist" value="{{ $album->artist }}">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">Title</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="title" value="{{ $album->title }}">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">Release Date</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="releaseDate" value="{{ $album->year }}">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">First Listened At</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="listenedAt" value="{{ $album->listenedAt }}">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">Rating</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="rating" value="{{ $album->rating }}">
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-default">Save</button>
            </div>
        </div>

    </form>
@endsection
