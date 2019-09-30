<?php

namespace ConorSmith\Music\Http\Controllers\Admin;

use ConorSmith\Music\Http\Controllers\Controller;
use ConorSmith\Music\Http\Requests\PostCreateWeeksAlbums;
use ConorSmith\Music\Model\Album;
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

class CreateWeeksAlbums extends Controller
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

    public function __invoke(Request $request)
    {
        $requestPayload = new PostCreateWeeksAlbums(
            $request->input('week'),
            $request->input('artist'),
            $request->input('album'),
            $request->input('releaseDate')
        );

        /** @var \ConorSmith\Music\Http\Requests\Album $albumPayload */
        foreach ($requestPayload->getAlbums() as $albumPayload) {
            $artist = $this->artistRepo->findByName($albumPayload->getArtistName());

            if (is_null($artist)) {
                $artist = new Artist(
                    ArtistId::generate(),
                    ArtistName::fromString($albumPayload->getArtistName())
                );
            }

            $album = new Album(
                AlbumId::generate(),
                AlbumTitle::fromString($albumPayload->getTitle()),
                $artist,
                new ReleaseDate($albumPayload->getReleaseDate()),
                new FirstListenTime($requestPayload->getWeek()),
                new Rating(0)
            );

            $this->albumRepo->save($album);
        }

        return redirect("/dashboard");
    }
}
