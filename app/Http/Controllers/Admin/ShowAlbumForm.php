<?php

namespace ConorSmith\Music\Http\Controllers\Admin;

use ConorSmith\Music\Http\Controllers\Controller;
use ConorSmith\Music\Infrastructure\TemplateVariables\Album as AlbumTemplateVariable;
use ConorSmith\Music\Model\AlbumId;
use ConorSmith\Music\Model\AlbumRepository;
use Illuminate\Http\Request;
use Rhumsaa\Uuid\Uuid;

class ShowAlbumForm extends Controller
{
    /** @var AlbumRepository */
    private $albumRepo;

    public function __construct(AlbumRepository $albumRepo)
    {
        $this->albumRepo = $albumRepo;
    }

    public function __invoke(Request $request, string $id)
    {
        return view('admin.album', [
            'album' => AlbumTemplateVariable::present(
                $this->albumRepo->find(
                    new AlbumId(Uuid::fromString($id))
                )
            )
        ]);
    }
}
