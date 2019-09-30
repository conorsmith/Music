<?php

namespace ConorSmith\Music\Http\Controllers\Admin;

use ConorSmith\Music\Http\Controllers\Controller;
use ConorSmith\Music\Infrastructure\TemplateVariables\Album as AlbumTemplateVariable;
use ConorSmith\Music\Model\Album;
use ConorSmith\Music\Model\AlbumRepository;

class ListAlbums extends Controller
{
    /** @var AlbumRepository */
    private $albumRepo;

    public function __construct(AlbumRepository $albumRepo)
    {
        $this->albumRepo = $albumRepo;
    }

    public function __invoke()
    {
        return view("admin.albums", [
            'albums' => collect(
                $this->albumRepo->allByFirstListenTime()
            )
                ->map(function (Album $album) {
                    return AlbumTemplateVariable::present($album);
                })
                ->toArray()
        ]);
    }
}
