<?php

namespace ConorSmith\Music\Http\Controllers\Admin;

use ConorSmith\Music\Http\Controllers\Controller;
use ConorSmith\Music\Model\AlbumRepository;
use ConorSmith\Music\Model\DiscographyRepository;
use ConorSmith\Music\Remote\GoogleDrive;
use ConorSmith\Music\Remote\ImportRepository;

class ImportFromGoogleSheets extends Controller
{
    /** @var AlbumRepository */
    private $albumRepo;

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
        $this->importRepo = $importRepo;
        $this->googleDrive = $googleDrive;
    }

    public function __invoke()
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
