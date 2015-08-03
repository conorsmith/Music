@extends('app')

@section('content')
    <div class="row">
        <div class="col-sm-offset-4 col-sm-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Music Dashboard</h3>
                </div>
                <div class="panel-body">

                    @if ($hasAccessToken)
                        <form method="post" action="/update">
                            {!! csrf_field() !!}
                            <button type="submit" class="btn btn-default btn-block btn-raised">
                                Update Cached Albums
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
