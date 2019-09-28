@extends('app')

@section('content')
    <div class="row">
        <div class="col-sm-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">This Week's Albums</h3>
                </div>
                <table class="table">
                    @foreach($thisWeeksAlbums as $album)
                        <tr>
                            <td>{{ $album->artist }}</td>
                            <td>{{ $album->title }}</td>
                            <td style="text-align: right;">
                                @if($album->rating)
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i * 2 <= $album->rating)
                                            <i class="mdi-toggle-star"></i>
                                        @elseif(($i * 2) - 1 == $album->rating)
                                            <i class="mdi-toggle-star-half"></i>
                                        @else
                                            <i class="mdi-toggle-star-outline"></i>
                                        @endif
                                    @endfor
                                @else
                                    <form class="form-inline" method="POST" action="/album/{{ $album->id }}/rating">
                                        {{ csrf_field() }}
                                        <input type="number" min="0" max="10" name="rating" class="form-control">
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Import Albums from Google Sheets</h3>
                </div>
                <div class="panel-body">

                    @if ($hasAccessToken)
                        <form method="post" action="/update">
                            {!! csrf_field() !!}
                            <button type="submit" class="btn btn-default btn-block btn-raised">
                                Import
                            </button>
                        </form>
                    @else
                        <div class="alert alert-warning">
                            There is currently no Access Token cached.
                            <form method="post" action="{{ route('auth.trigger') }}">
                                {!! csrf_field() !!}
                                <button class="btn btn-block btn-link alert-link">
                                    Authenticate with Google
                                </button>
                            </form>
                        </div>
                    @endif

                </div>
                <ul class="list-group">
                    <p>
                      <a href="{{ route('albums') }}" class="list-group-item">
                          <span class="badge">{{ $albumCount }}</span> Albums
                      </a>
                    </p>
                    <p>
                      <a href="{{ route('artists') }}" class="list-group-item">
                          <span class="badge">{{ $artistCount }}</span> Artists
                      </a>
                    </p>
                </ul>
            </div>
        </div>
    </div>
@endsection
