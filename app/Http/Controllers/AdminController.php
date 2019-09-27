<?php

namespace ConorSmith\Music\Http\Controllers;

use ConorSmith\Music\Model\AlbumRepository;
use ConorSmith\Music\Model\DiscographyRepository;
use ConorSmith\Music\Remote\GoogleDrive;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard(AlbumRepository $albumRepo, DiscographyRepository $discographyRepo)
    {
        return view('dashboard', [
            'hasAccessToken' => \Cache::has('google.access_token'),
            'albumCount' => count($albumRepo->allByFirstListenTime()),
            'artistCount' => count($discographyRepo->allByArtistName()),
        ]);
    }

    public function update(AlbumRepository $repo, GoogleDrive $drive)
    {
        $repo->destroy();

        $import = $drive->requestAlbums();

        $repo->saveAll([
            'artists' => $import->getArtists(),
            'albums' => $import->getAlbums(),
        ]);

        return redirect('/dashboard');
    }
}
