<?php

namespace ConorSmith\Music\Persistence;

use ConorSmith\Music\Clock;
use ConorSmith\Music\Model\Album;
use ConorSmith\Music\Model\AlbumRepository;
use Illuminate\Cache\Repository;

class AlbumStructCacheRepository implements AlbumRepository
{
    public const ALL_DATA_KEY = 'data';

    /** @var Repository */
    private $cache;

    /** @var Clock */
    private $clock;

    public function __construct(Repository $cache, Clock $clock)
    {
        $this->cache = $cache;
        $this->clock = $clock;
    }

    public function saveAll(array $albums)
    {
        $this->cache->forever(self::ALL_DATA_KEY, $albums);
    }

    public function save(Album $album)
    {
        $this->cache->forever($album->getId(), [
            'id'          => $album->getId()->__toString(),
            'title'       => $album->getTitle()->__toString(),
            'artist'      => [
                'id'   => $album->getArtist()->getId()->__toString(),
                'name' => $album->getArtist()->getName()->__toString(),
            ],
            'releaseDate' => $album->getReleaseDate()->getValue(),
            'listenedAt'  => $album->getListenedAt()->getDate()->format("Y-m-d"),
            'rating'      => $album->getRating()->getValue(),
        ]);
    }

    public function destroy()
    {
        $this->cache->flush();
    }

    public function allByFirstListenTime()
    {
        if (!$this->cache->has(self::ALL_DATA_KEY)) {
            return [];
        }

        return collect($this->cache->get(self::ALL_DATA_KEY)['albums'])
            ->reverse()
            ->toArray();
    }

    public function findForThisWeek()
    {
        if (!$this->cache->has(self::ALL_DATA_KEY)) {
            return [];
        }

        return collect($this->cache->get(self::ALL_DATA_KEY)['albums'])
            ->filter(function ($album) {
                return $album->getListenedAt()->isFromListeningPeriod($this->clock->mondayThisWeek());
            })
            ->values()
            ->toArray();
    }
}
