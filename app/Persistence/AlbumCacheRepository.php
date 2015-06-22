<?php

namespace ConorSmith\Music\Persistence;

use ConorSmith\Music\Model\AlbumRepository;
use Illuminate\Cache\Repository;

class AlbumCacheRepository implements AlbumRepository
{
    const KEY = 'data';

    private $cache;

    public function __construct(Repository $cache)
    {
        $this->cache = $cache;
    }

    public function all()
    {
        if (!$this->cache->has(self::KEY)) {
            return [
                'albums' => [],
                'artists' => [],
            ];
        }

        return $this->cache->get(self::KEY);
    }

    public function save(array $albums)
    {
        $this->cache->forever(self::KEY, $albums);
    }

    public function destroy()
    {
        $this->cache->forget(self::KEY);
    }
}
