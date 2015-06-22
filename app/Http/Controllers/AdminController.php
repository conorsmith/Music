<?php

namespace ConorSmith\Music\Http\Controllers;

use ConorSmith\Music\Model\AlbumRepository;
use ConorSmith\Music\Remote\GoogleDrive;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard(AlbumRepository $repo)
    {
        $albums = $repo->all();

        return view('dashboard', [
            'hasAccessToken' => \Cache::has('google.access_token'),
            'albumCount' => count($albums['albums']),
            'artistCount' => count($albums['artists']),
        ]);
    }

    public function update(AlbumRepository $repo, GoogleDrive $drive)
    {
        $repo->destroy();

        $repo->save($drive->requestAlbums());

        return redirect('/dashboard');
    }
}
