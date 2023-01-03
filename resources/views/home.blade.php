@extends('app')

@section('content')

  <div class="panel panel-default">
    <div class="panel-heading">This Week's Albums</div>
    <div class="panel-body">
      <div class="row">

        @if(count($albums) > 0)
          @foreach($albums as $i => $album)
            <div class="col-md-2 {{ $i === 0 && count($albums) < 6 ? 'col-md-offset-' . (6 - count($albums)) : '' }}"
                style="text-align: center;">
              <img src="https://coverartarchive.org/release/54c917b3-5955-4b2a-b1b7-b129d126eeff/8121540978-250.jpg" style="width: 150px; height: 150px;">
              <h4 style="margin-bottom: 6px;">{{ $album->title }}</h4>
              <p style="margin-bottom: 3px;"><strong>{{ $album->artist }}</strong></p>
              <p><em>{{ $album->year }}</em></p>
            </div>
          @endforeach
        @else
          <h2 style="text-align: center; font-weight: bold; text-transform: uppercase; color: #666;">No albums this week</h2>
        @endif
      </div>
    </div>
  </div>

  <div class="row">

    <div class="col-md-4">
      <div class="panel panel-default">
        <div class="panel-heading">Spotify Playlists</div>
        <table class="table" style="font-size: 18px; font-weight: bold; text-align: center;">
          <tr><td><a href="https://open.spotify.com/user/conorbsmith/playlist/6XIKbhQPEngjIoqZbEjO8R?si=suS4H4y2RM2_jybA_zIUzg" style="display: block;" target="_blank">Why Not?</a></td></tr>
          <tr><td><a href="https://open.spotify.com/user/conorbsmith/playlist/5bwC6oS06VV5NfjWUHgMwj?si=TENNmuaLQ6aDSLsd35EfoQ" style="display: block;" target="_blank">Obviously</a></td></tr>
          <tr><td><a href="https://open.spotify.com/playlist/0p5Nxy5t3NjdDfAnT3ClPC?si=1tLecLXOSS-OZLP_8mRhSg" style="display: block;" target="_blank">One a Piece</a></td></tr>
          <tr><td><a href="https://open.spotify.com/user/conorbsmith/playlist/77W1COwhHoyqK8vv94L70Z?si=hnDPgRniSuWw314tmDq4ng" style="display: block;" target="_blank">Great TV Tracks</a></td></tr>
          <tr><td><a href="https://open.spotify.com/playlist/6J4uGiaOYwCwRFXPl8m6Yn?si=BAXrID5rQvuhj9PTFOUbrQ" style="display: block;" target="_blank">1 2 3</a></td></tr>
          <tr><td><a href="https://open.spotify.com/user/conorbsmith/playlist/0lTaHurEjAOela1j0wkKtw?si=F0pRreQSQtGATfSR1RGt8w" style="display: block;" target="_blank">30</a></td></tr>
          <tr><td><a href="https://open.spotify.com/playlist/6nZSMsk5lrKxY1rhxOYLJQ?si=u0RuWHhCRgyTRyVAScZblw" style=display: block;" target="_blank">Top 2020 Tracks</a></td></tr>
          <tr><td><a href="https://open.spotify.com/playlist/46shsYJgPTzY1ar1sl1hjf?si=dWF5i4CCTTeYv5ogZ6m0IA" style="display: block;" target="_blank">Top 2019 Tracks</a></td></tr>
          <tr><td><a href="https://open.spotify.com/user/conorbsmith/playlist/3TuFrgRGVW0cuvq8E04brL?si=MCdc39_TQpm1xzByKHFVXQ" style="display: block;" target="_blank">Top 2018 Tracks</a></td></tr>
          <tr><td><a href="https://open.spotify.com/user/conorbsmith/playlist/2n61FUNrYRBcfWC9Ui5XJh?si=YT7juBepTb2QUtgJxHtqfg" style="display: block;" target="_blank">Top 2017 Tracks</a></td></tr>
          <tr><td><a href="https://open.spotify.com/user/conorbsmith/playlist/5KnYIXuFpgVyC3k1KD5XUc?si=immeBkstSVO8i4gDwEkTlQ" style="display: block;" target="_blank">Top 2016 Tracks</a></td></tr>
          <tr><td><a href="https://open.spotify.com/user/conorbsmith/playlist/4bMwkdOFKI8Fi1He4Itvc4?si=2hBgYyjgQQ2Lu9kieo7grA" style="display: block;" target="_blank">Finds of 2016</a></td></tr>
          <tr><td><a href="https://open.spotify.com/playlist/1E8xeHZO5UL9v8Mma12Tpd?si=jLL-CDY0SGiJiY8aYVThFA" style="display: block;" target="_blank">Summer 2005</a></td></tr>
        </table>
      </div>
    </div>

    <div class="col-md-4">
      <div class="panel panel-default">
        <div class="panel-heading">Willennium</div>
        <div class="panel-body" style="text-align: center;">
          <p style="font-size: 90px; font-weight: bold;">6</p>
          <p>Current Number of Copies of <em>Willennium</em><br>owned by Conor Smith</p>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="panel panel-default">
        <div class="panel-heading">Top Ten Albums</div>
        <div class="panel-body"><p>These are Conor Smith's top ten albums each year for a number of recent years.</p></div>
        <table class="table" style="font-size: 18px; font-weight: bold; text-align: center;">
          <tr><td><a href="http://conorsmith.ie/music/top-ten-albums-of-2022" style="display: block;">2022</a></td></tr>
          <tr><td><a href="http://conorsmith.ie/music/top-ten-albums-of-2021" style="display: block;">2021</a></td></tr>
          <tr><td><a href="http://conorsmith.ie/music/top-ten-albums-of-2020" style="display: block;">2020</a></td></tr>
          <tr><td><a href="http://conorsmith.ie/music/top-ten-albums-of-2019" style="display: block;">2019</a></td></tr>
          <tr><td><a href="http://conorsmith.ie/music/top-ten-albums-of-2018" style="display: block;">2018</a></td></tr>
          <tr><td><a href="http://conorsmith.ie/music/top-ten-albums-of-2017" style="display: block;">2017</a></td></tr>
          <tr><td><a href="http://conorsmith.ie/music/top-ten-albums-of-2016" style="display: block;">2016</a></td></tr>
          <tr><td><a href="http://conorsmith.ie/music/top-ten-albums-of-2015" style="display: block;">2015</a></td></tr>
          <tr><td><a href="http://conorsmith.ie/music/top-ten-albums-of-2014" style="display: block;">2014</a></td></tr>
        </table>
      </div>
    </div>

  </div>

@endsection
