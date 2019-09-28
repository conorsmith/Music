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

    /** @var ImportRepository */
    private $importRepo;

    /** @var GoogleDrive */
    private $googleDrive;

    public function __construct(
        AlbumRepository $albumRepo,
        DiscographyRepository $discographyRepo,
        ImportRepository $importRepo,
        GoogleDrive $googleDrive
    ) {
        $this->albumRepo = $albumRepo;
        $this->discographyRepo = $discographyRepo;
        $this->importRepo = $importRepo;
        $this->googleDrive = $googleDrive;
    }

    public function dashboard()
    {
        return view('dashboard', [
            'hasAccessToken' => \Session::has('google.access_token'),
            'albumCount' => count($this->albumRepo->allByFirstListenTime()),
            'artistCount' => count($this->discographyRepo->allByArtistName()),
        ]);
    }

    public function update()
    {
        $this->importRepo->deleteAllImportedAlbums();

        $import = $this->googleDrive->requestAlbums();

        foreach ($import->getAlbums() as $album) {
            $this->albumRepo->save($album);
        }

        $this->importRepo->markAllAlbumsAsImported();

        return redirect('/dashboard');
    }
}
