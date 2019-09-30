@extends('layouts.admin')

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
                                            <i class="fas fa-star"></i>
                                        @elseif(($i * 2) - 1 == $album->rating)
                                            <i class="fas fa-star-half-alt"></i>
                                        @else
                                            <i class="far fa-star"></i>
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
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Next Week's Albums</h3>
                </div>
                <div class="panel-body">
                    <div style="width: 40%; margin: 0 auto;">
                        <a href="/weeks-albums/new" class="btn btn-primary btn-block">Add Next Week's Albums</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Statistics</h3>
                </div>
                <ul class="list-group">
                    <li class="list-group-item" style="padding-top: 10px; padding-bottom: 10px;">
                        <span class="badge">{{ $albumCount }}</span> Albums
                    </li>
                    <li class="list-group-item" style="padding-top: 10px; padding-bottom: 10px;">
                        <span class="badge">{{ $artistCount }}</span> Artists
                    </li>
                </ul>
            </div>
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
                        <div class="alert alert-warning" style="margin-bottom: 0;">
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
            </div>
        </div>
    </div>
@endsection
