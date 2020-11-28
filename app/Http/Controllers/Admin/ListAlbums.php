<?php

namespace ConorSmith\Music\Http\Controllers\Admin;

use ConorSmith\Music\Http\Controllers\Controller;
use ConorSmith\Music\Infrastructure\TemplateVariables\Album as AlbumTemplateVariable;
use ConorSmith\Music\Model\Album;
use ConorSmith\Music\Model\AlbumRepository;
use Illuminate\Http\Request;

class ListAlbums extends Controller
{
    /** @var AlbumRepository */
    private $albumRepo;

    public function __construct(AlbumRepository $albumRepo)
    {
        $this->albumRepo = $albumRepo;
    }

    public function __invoke(Request $request)
    {
        $query = $this->createQuery($request);

        return view("admin.albums", [
            'albums' => collect(
                $this->albumRepo->search($query)
            )
                ->map(function (Album $album) {
                    return AlbumTemplateVariable::present($album);
                })
                ->toArray()
        ]);
    }

    private function createQuery(Request $request)
    {
        $filter = $request->query('filter');
        $sort = $request->query('sort');

        return new class(
            array_get($filter, 'first_listen_year'),
            array_key_exists('minimum_rating', $filter) ? intval($filter['minimum_rating']) : null,
            array_get($filter, 'release_year'),
            $sort === "artist",
            $sort === "album"
        ) {
            /** @var ?string */
            private $firstListenYear;

            /** @var ?int */
            private $minimumRating;

            /** @var ?string */
            private $releaseYear;

            /** @var bool */
            private $sortByArtist;

            /** @var bool */
            private $sortByAlbum;

            public function __construct(
                ?string $firstListenYear,
                ?int $minimumRating,
                ?string $releaseYear,
                bool $sortByArtist,
                bool $sortByAlbum
            ) {
                $this->firstListenYear = $firstListenYear;
                $this->minimumRating = $minimumRating;
                $this->releaseYear = $releaseYear;
                $this->sortByArtist = $sortByArtist;
                $this->sortByAlbum = $sortByAlbum;
            }

            public function hasFiltersOrSort(): bool
            {
                return !is_null($this->firstListenYear)
                    || !is_null($this->minimumRating)
                    || !is_null($this->releaseYear)
                    || $this->sortByArtist
                    || $this->sortByAlbum;
            }

            public function getFirstListenYear(): ?string
            {
                return $this->firstListenYear;
            }

            public function getMinimumRating(): ?int
            {
                return $this->minimumRating;
            }

            public function getReleaseYear(): ?string
            {
                return $this->releaseYear;
            }

            public function sortByArtist(): bool
            {
                return $this->sortByArtist;
            }

            public function sortByAlbum(): bool
            {
                return $this->sortByAlbum;
            }
        };
    }
}
