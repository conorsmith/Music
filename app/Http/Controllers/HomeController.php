<?php

namespace ConorSmith\Music\Http\Controllers;

use ConorSmith\Music\Model\Album;
use ConorSmith\Music\Model\AlbumRepository;
use ConorSmith\Music\Model\Artist;

class HomeController extends Controller
{
    private $repo;

    public function __construct(AlbumRepository $repo)
    {
        $this->repo = $repo;
    }

    public function index()
    {
        $data = $this->repo->all();

        return view('home', [
            'albums' => array_map([$this, 'transformAlbum'], array_reverse($data['albums'])),
        ]);
    }

    public function artists()
    {
        $data = $this->repo->all();

        $artists = $data['artists'];

        uasort($artists, function ($a, $b) {
            return strcasecmp($a[0]->getArtist()->getName(), $b[0]->getArtist()->getName());
        });

        return view('artists', [
            'artists' => array_map(function (array $albums) {
                uasort($albums, function ($a, $b) {
                    return strcasecmp($a->getReleaseDate()->getValue(), $b->getReleaseDate()->getValue());
                });

                return array_map([$this, 'transformAlbum'], $albums);
            }, $artists),
        ]);
    }

    private function transformAlbum(Album $album)
    {
        return [
            'title' => strval($album->getTitle()),
            'artist' => strval($album->getArtist()->getName()),
            'listened_at' => $album->getListenedAt()->getDate()->format('d/m/Y'),
            'year' => strval($album->getReleaseDate()->getValue()),
            'rating' => $album->getRating()->getValue(),
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
