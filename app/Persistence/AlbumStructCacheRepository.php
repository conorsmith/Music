<?php

namespace ConorSmith\Music\Persistence;

use ConorSmith\Music\Model\AlbumRepository;
use Illuminate\Cache\Repository;

class AlbumStructCacheRepository implements AlbumRepository
{
    const KEY = 'data';

    private $cache;

    public function __construct(Repository $cache)
    {
        $this->cache = $cache;
    }

    public function save(array $albums)
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
}
