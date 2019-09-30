<?php

namespace ConorSmith\Music\Http\Controllers\Admin;

use ConorSmith\Music\Http\Controllers\Controller;
use ConorSmith\Music\Model\AlbumId;
use ConorSmith\Music\Model\AlbumRepository;
use ConorSmith\Music\Model\AlbumTitle;
use ConorSmith\Music\Model\Artist;
use ConorSmith\Music\Model\ArtistId;
use ConorSmith\Music\Model\ArtistName;
use ConorSmith\Music\Model\ArtistRepository;
use ConorSmith\Music\Model\FirstListenTime;
use ConorSmith\Music\Model\Rating;
use ConorSmith\Music\Model\ReleaseDate;
use Illuminate\Http\Request;
use Rhumsaa\Uuid\Uuid;

class ModifyAlbum extends Controller
{
    /** @var AlbumRepository */
    private $albumRepo;

    /** @var ArtistRepository */
    private $artistRepo;

    public function __construct(AlbumRepository $albumRepo, ArtistRepository $artistRepo)
    {
        $this->albumRepo = $albumRepo;
        $this->artistRepo = $artistRepo;
    }

    public function __invoke(Request $request, string $id)
    {
        $album = $this->albumRepo->find(
            new AlbumId(Uuid::fromString($id))
        );

        $artist = $this->artistRepo->findByName(
            ArtistName::fromString($request->input('artist'))
        );

        if (is_null($artist)) {
            $artist = new Artist(
                ArtistId::generate(),
                ArtistName::fromString($request->input('artist'))
            );
        }

        $album->setArtist($artist);
        $album->setTitle(AlbumTitle::fromString($request->input('title')));
        $album->setReleaseDate(new ReleaseDate(intval($request->input('releaseDate'))));
        $album->setListenedAt(FirstListenTime::fromDateAsString($request->input('listenedAt')));
        $album->rate(new Rating(intval($request->input('rating'))));

        $this->albumRepo->update($album);

        $request->session()->flash('success', "Album data updated");

        return redirect("/admin/album/{$id}");
    }
}
