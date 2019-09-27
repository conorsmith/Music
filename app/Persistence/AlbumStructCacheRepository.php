<?php

namespace ConorSmith\Music\Persistence;

use ConorSmith\Music\Clock;
use ConorSmith\Music\Model\AlbumRepository;
use Illuminate\Cache\Repository;

class AlbumStructCacheRepository implements AlbumRepository
{
    const KEY = 'data';

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
        $this->cache->forever(self::KEY, $albums);
    }

    public function destroy()
    {
        $this->cache->forget(self::KEY);
    }

    public function allByFirstListenTime()
    {
        if (!$this->cache->has(self::KEY)) {
            return [];
        }

        return collect($this->cache->get(self::KEY)['albums'])
            ->reverse()
            ->toArray();
    }

    public function findForThisWeek()
    {
        if (!$this->cache->has(self::KEY)) {
            return [];
        }

        return collect($this->cache->get(self::KEY)['albums'])
            ->filter(function ($album) {
                return $album->getListenedAt()->isFromListeningPeriod($this->clock->mondayThisWeek());
            })
            ->values()
            ->toArray();
    }
}
