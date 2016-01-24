<?php

namespace ConorSmith\Music\Http\Controllers;

use ConorSmith\Music\Model\AlbumRepository;
use ConorSmith\Music\Model\ArtistRepository;
use ConorSmith\Music\Remote\GoogleDrive;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard(AlbumRepository $albumRepo, ArtistRepository $artistRepo)
    {
        return view('dashboard', [
            'hasAccessToken' => \Cache::has('google.access_token'),
            'albumCount' => count($albumRepo->allByFirstListenTime()),
            'artistCount' => count($artistRepo->allByName()),
        ]);
    }

    public function update(AlbumRepository $repo, GoogleDrive $drive)
    {
        $repo->destroy();

        $import = $drive->requestAlbums();

        $repo->save([
            'artists' => $import->getArtists(),
            'albums' => $import->getAlbums(),
        ]);

        return redirect('/dashboard');
    }
}
