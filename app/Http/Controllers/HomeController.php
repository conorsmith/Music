<?php

namespace ConorSmith\Music\Http\Controllers;

use ConorSmith\Music\Model\Album;
use ConorSmith\Music\Model\AlbumRepository;
use ConorSmith\Music\Model\Artist;
use ConorSmith\Music\Model\DiscographyRepository;

class HomeController extends Controller
{
    public function index(AlbumRepository $albumRepo)
    {
        $albums = $albumRepo->allByFirstListenTime();

        return view('home', [
            'albums' => $this->transformAlbums($albums),
        ]);
    }

    public function artists(DiscographyRepository $discographyRepo)
    {
        $discographies = $discographyRepo->allByArtistName();

        return view('artists', [
            'artists' => collect($discographies)
                ->map(function (array $albums) {
                    return $this->transformAlbums($albums);
                })
                ->toArray(),
        ]);
    }

    private function transformAlbums(array $albums)
    {
        return collect($albums)
            ->map(function ($album) {
                return $this->transformAlbum($album);
            })
            ->toArray();
    }

    private function transformAlbum(Album $album)
    {
        return [
            'title'         => strval($album->getTitle()),
            'artist'        => strval($album->getArtist()->getName()),
            'listened_at'   => $album->getListenedAt()->getDate()->format('d/m/Y'),
            'year'          => strval($album->getReleaseDate()->getValue()),
            'rating'        => $album->getRating()->getValue(),
            'artist_colour' => $this->getColourForArtist($album->getArtist()),
        ];
    }

    private function getColourForArtist(Artist $artist)
    {
        $classesByLetter = [
            'a' => "material-red",
            'b' => "material-red",
            'c' => "material-pink",
            'd' => "material-pink",
            'e' => "material-purple",
            'f' => "material-purple",
            'g' => "material-deeppurple",
            'h' => "material-deeppurple",
            'i' => "material-indigo",
            'j' => "material-indigo",
            'k' => "material-lightblue",
            'l' => "material-lightblue",
            'm' => "material-cyan",
            'n' => "material-cyan",
            'o' => "material-teal",
            'p' => "material-teal",
            'q' => "success",
            'r' => "success",
            's' => "material-lightgreen",
            't' => "material-lightgreen",
            'u' => "material-lime",
            'v' => "material-lime",
            'w' => "material-lightyellow",
            'x' => "material-lightyellow",
            'y' => "material-orange",
            'z' => "material-orange",
        ];

        $artistFirstLetter = strtolower(substr($artist->getName(), 0, 1));

        if (!array_key_exists($artistFirstLetter, $classesByLetter)) {
            return "material-red";
        }

        return $classesByLetter[$artistFirstLetter];
    }
}
