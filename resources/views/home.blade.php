@extends('app')

@section('tabs')
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <ul class="nav navbar-nav">
        <li class="active"><a href="/">Albums</a></li>
        <li><a href="/artists">Artists</a></li>
      </ul>
    </div>
  </nav>
@endsection

@section('content')

  <div class="table-responsive" style="background: #fff;">
    <table class="table">
        <thead>
            <tr>
                <th>Listened</th>
                <th>Artist</th>
                <th>Album</th>
                <th>Year</th>
                <th>Rating</th>
            </tr>
        </thead>
        @foreach ($albums as $album)
            <tr>
                <td>{{ $album['listened_at'] }}</td>
                <td><a href="/artists/#{{ $album['artist'] }}">{{ $album['artist'] }}</a></td>
                <td>{{ $album['title'] }}</td>
                <td>{{ $album['year'] ?: "&ndash;" }}</td>
                <td style="width: 160px;">
                    @if($album['rating'])
                        @for($i = 1; $i <= 5; $i++)
                            @if($i * 2 <= $album['rating'])
                                <i class="mdi-toggle-star"></i>
                            @elseif(($i * 2) - 1 == $album['rating'])
                                <i class="mdi-toggle-star-half"></i>
                            @else
                                <i class="mdi-toggle-star-outline"></i>
                            @endif
                        @endfor
                    @endif
                </td>
            </tr>
        @endforeach
    </table>
  </div>
@endsection
