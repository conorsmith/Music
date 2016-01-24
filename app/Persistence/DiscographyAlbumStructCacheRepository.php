<?php

namespace ConorSmith\Music\Persistence;

use ConorSmith\Music\Model\Discography;
use ConorSmith\Music\Model\DiscographyRepository;
use Illuminate\Contracts\Cache\Repository;

class DiscographyAlbumStructCacheRepository implements DiscographyRepository
{
    private $cache;

    public function __construct(Repository $cache)
    {
        $this->cache = $cache;
    }

    public function allByArtistName()
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
                return Discography::fromAlbums(collect($albums)
                    ->sort(function ($a, $b) {
                        return strcasecmp(
                            $a->getReleaseDate()->getValue(),
                            $b->getReleaseDate()->getValue()
                        );
                    })
                    ->toArray());
            })
            ->toArray();
    }
}
