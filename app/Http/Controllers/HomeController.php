<?php

namespace ConorSmith\Music\Http\Controllers;

use ConorSmith\Music\Model\AlbumRepository;

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
            'albums' => $data['albums'],
        ]);
    }

    public function artists()
    {
        $data = $this->repo->all();

        return view('artists', [
            'artists' => $data['artists'],
        ]);
    }
}
