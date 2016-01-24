<?php

namespace ConorSmith\Music\Persistence;

use ConorSmith\Music\Model\ArtistRepository;
use Illuminate\Contracts\Cache\Repository;

class ArtistAlbumStrictCacheRepository implements ArtistRepository
{
    private $cache;

    public function __construct(Repository $cache)
    {
        $this->cache = $cache;
    }

    public function allByName()
    {
        if (!$this->cache->has(AlbumStructCacheRepository::KEY)) {
            return [];
        }

        return collect($this->cache->get(AlbumStructCacheRepository::KEY)['artists'])
            ->sort(function ($a, $b) {
                return strcasecmp(
                    $a[0]->getArtist()->getName(),
                    $b[0]->getArtist()->getName()
                );
            })
            ->map(function (array $albums) {
                return collect($albums)
                    ->sort(function ($a, $b) {
                        return strcasecmp(
                            $a->getReleaseDate()->getValue(),
                            $b->getReleaseDate()->getValue()
                        );
                    })
                    ->toArray();
            })
            ->toArray();
    }
}
