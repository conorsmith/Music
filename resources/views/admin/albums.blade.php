@extends('layouts.admin')

@section('content')
    <table class="table">
        <thead>
            <tr>
                <th>Week</th>
                <th>Artist</th>
                <th>Album</th>
                <th style="text-align: right;">Released</th>
                <th>Rating</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($albums as $album)
                <tr>
                    <td>{{ $album->listenedAt }}</td>
                    <td>{{ $album->artist }}</td>
                    <td>{{ $album->title }}</td>
                    <td style="text-align: right;">{{ $album->year }}</td>
                    <td style="width: 120px;">
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
                        @endif
                    </td>
                    <td>
                        <a href="/admin/album/{{ $album->id }}" class="btn btn-xs btn-default">Edit</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
