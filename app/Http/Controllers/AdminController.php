<?php

namespace ConorSmith\Music\Http\Controllers;

use ConorSmith\Music\Model\AlbumRepository;
use ConorSmith\Music\Model\DiscographyRepository;
use ConorSmith\Music\Remote\GoogleDrive;
use ConorSmith\Music\Remote\ImportRepository;

class AdminController extends Controller
{
    /** @var AlbumRepository */
    private $albumRepo;

    /** @var DiscographyRepository */
    private $discographyRepo;

    public function __construct(AlbumRepository $albumRepo, DiscographyRepository $discographyRepo)
    {
        $this->albumRepo = $albumRepo;
        $this->discographyRepo = $discographyRepo;

        $this->middleware('auth');
    }

    public function dashboard()
    {
        return view('dashboard', [
            'hasAccessToken' => \Session::has('google.access_token'),
            'albumCount' => count($this->albumRepo->allByFirstListenTime()),
            'artistCount' => count($this->discographyRepo->allByArtistName()),
        ]);
    }

    public function update(ImportRepository $importRepo, GoogleDrive $drive)
    {
        $importRepo->deleteAllImportedAlbums();

        $import = $drive->requestAlbums();

        foreach ($import->getAlbums() as $album) {
            $this->albumRepo->save($album);
        }

        $importRepo->markAllAlbumsAsImported();

        return redirect('/dashboard');
    }
}
