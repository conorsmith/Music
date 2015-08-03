@extends('app')

@section('tabs')
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <ul class="nav navbar-nav">
        <li><a href="/">Albums</a></li>
        <li class="active"><a href="/artists">Artists</a></li>
      </ul>
    </div>
  </nav>
@endsection

@section('content')
  @foreach($artists as $artist)
    <div class="card card-default card-{{ $artist[0]['artist_colour'] }}" id="{{ $artist[0]['artist'] }}">
      <div class="card-body">
        <h4>{{ $artist[0]['artist'] }}</h4>
        {{--
        @foreach($artist as $album)
          <p>
            {{ $album['title'] }}
            @if ($album['year'])
              [{{ $album['year'] }}]
            @endif
            <small class="">
              ({{ $album['listened_at'] }})
            </small>
          </p>
        @endforeach
        --}}
        <table class="table">
          @foreach($artist as $album)
            <tr>
              <td>{{ $album['title'] }}</td>
              <td style="width: 40px;">
                @if($album['year'])
                  {{ $album['year'] }}
                @endif
              </td>
              <td style="width: 40px; opacity: 0.75;">
                {{ $album['listened_at'] }}
              </td>
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
    </div>
  @endforeach
@endsection
