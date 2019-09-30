@extends('layouts.admin')

@section('content')
    <form class="form-horizontal" method="POST" action="/weeks-albums">

        {{ csrf_field() }}

        <div class="form-group">
            <label class="col-sm-2 control-label">Week</label>
            <div class="col-sm-10">
                <input type="date" class="form-control" name="week">
            </div>
        </div>

        @for($i = 0; $i < 5; $i++)

            <hr>

            <div class="form-group">
                <label class="col-sm-2 control-label">Artist</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="artist[]">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">Album</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="album[]">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">Release Date</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="releaseDate[]" value="{{ date("Y") }}">
                </div>
            </div>

        @endfor

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-default">Create</button>
            </div>
        </div>

    </form>
@endsection
