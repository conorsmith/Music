<?php

namespace ConorSmith\Music\Http\Controllers\Admin;

use ConorSmith\Music\Http\Controllers\Controller;
use ConorSmith\Music\Infrastructure\TemplateVariables\Album as AlbumTemplateVariable;
use ConorSmith\Music\Model\Album;
use ConorSmith\Music\Model\AlbumRepository;
use ConorSmith\Music\Model\DiscographyRepository;

class ShowDashboard extends Controller
{
    /** @var AlbumRepository */
    private $albumRepo;

    /** @var DiscographyRepository */
    private $discographyRepo;

    public function __construct(
        AlbumRepository $albumRepo,
        DiscographyRepository $discographyRepo
    ) {
        $this->albumRepo = $albumRepo;
        $this->discographyRepo = $discographyRepo;
    }

    public function __invoke()
    {
        return view('dashboard', [
            'hasAccessToken'  => \Session::has('google.access_token'),
            'albumCount'      => count($this->albumRepo->allByFirstListenTime()),
            'artistCount'     => count($this->discographyRepo->allByArtistName()),
            'thisWeeksAlbums' => collect($this->albumRepo->findForThisWeek())
                ->map(function (Album $album) {
                    return AlbumTemplateVariable::present($album);
                })
                ->toArray()
        ]);
    }
}
