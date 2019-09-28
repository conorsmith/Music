<?php

namespace ConorSmith\Music\Http\Controllers\Admin;

use ConorSmith\Music\Http\Controllers\Controller;
use ConorSmith\Music\Model\AlbumId;
use ConorSmith\Music\Model\AlbumRepository;
use ConorSmith\Music\Model\Rating;
use Illuminate\Http\Request;
use Rhumsaa\Uuid\Uuid;

class CreateAlbumRating extends Controller
{
    /** @var AlbumRepository */
    private $albumRepo;

    public function __construct(AlbumRepository $albumRepo)
    {
        $this->albumRepo = $albumRepo;
    }

    public function __invoke(Request $request, string $id)
    {
        $album = $this->albumRepo->find(new AlbumId(Uuid::fromString($id)));

        $album->rate(new Rating(intval($request->input('rating'))));

        $this->albumRepo->update($album);

        return redirect("/dashboard");
    }
}
