@extends('app')

@section('tabs')
    <ul class="nav nav-tabs" style="margin-bottom: 10px;">
      <li role="presentation"><a href="/">Albums</a></li>
      <li role="presentation" class="active"><a href="/artists">Artists</a></li>
    </ul>
@endsection

@section('content')
    <div class="list-group">
        @foreach ($artists as $artist)
            <div class="list-group-item">
                <h4 class="list-group-item-heading" id="{{ $artist[0]['artist'] }}">{{ $artist[0]['artist'] }}</h4>
                @foreach ($artist as $album)
                    <p class="list-group-item-text">
                        {{ $album['title'] }}
                        @if ($album['year'])
                            [{{ $album['year'] }}]
                        @endif
                        <small class="text-muted">
                            ({{ $album['listened_at'] }})
                        </small>
                    </p>
                @endforeach
            </div>
        @endforeach
    </div>
@endsection
