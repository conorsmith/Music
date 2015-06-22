@extends('app')

@section('tabs')
    <ul class="nav nav-tabs" style="margin-bottom: 10px;">
      <li role="presentation" class="active"><a href="/">Albums</a></li>
      <li role="presentation"><a href="/artists">Artists</a></li>
    </ul>
@endsection

@section('content')
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Listened</th>
                <th>Artist</th>
                <th>Album</th>
                <th>Year</th>
            </tr>
        </thead>
        @foreach ($albums as $album)
            <tr>
                <td>{{ $album['listened_at'] }}</td>
                <td><a href="/artists/#{{ $album['artist'] }}">{{ $album['artist'] }}</a></td>
                <td>{{ $album['title'] }}</td>
                <td>{{ $album['year'] ?: "&ndash;" }}</td>
            </tr>
        @endforeach
    </table>
@endsection
