<?php

namespace ConorSmith\Music\Persistence;

use Carbon\Carbon;
use ConorSmith\Music\Clock;
use ConorSmith\Music\Model\Album;
use ConorSmith\Music\Model\AlbumId;
use ConorSmith\Music\Model\AlbumRepository;
use ConorSmith\Music\Model\AlbumTitle;
use ConorSmith\Music\Model\Artist;
use ConorSmith\Music\Model\ArtistId;
use ConorSmith\Music\Model\ArtistName;
use ConorSmith\Music\Model\FirstListenTime;
use ConorSmith\Music\Model\NullReleaseDate;
use ConorSmith\Music\Model\Rating;
use ConorSmith\Music\Model\ReleaseDate;
use Illuminate\Cache\Repository;
use Rhumsaa\Uuid\Uuid;

class AlbumStructCacheRepository implements AlbumRepository
{
    public const ALL_DATA_KEY = 'data';

    private const ALBUM_INDEX_KEY = 'album_index';

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
        $albumIndex = $this->cache->get(self::ALBUM_INDEX_KEY);

        if (!is_array($albumIndex)) {
            $albumIndex = [];
        }

        $albumIndex[] = $album->getId()->__toString();

        $this->cache->forever(self::ALBUM_INDEX_KEY, $albumIndex);

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
        $albumIndex = $this->cache->get(self::ALBUM_INDEX_KEY);

        if (!is_array($albumIndex)) {
            return [];
        }

        $albums = [];

        foreach ($albumIndex as $albumId) {
            $albumData = $this->cache->get($albumId);

            $album = new Album(
                new AlbumId(Uuid::fromString($albumId)),
                AlbumTitle::fromString($albumData['title']),
                new Artist(
                    new ArtistId(Uuid::fromString($albumData['artist']['id'])),
                    ArtistName::fromString($albumData['artist']['name'])
                ),
                is_null($albumData['releaseDate'])
                    ? NullReleaseDate::create()
                    : new ReleaseDate($albumData['releaseDate']),
                new FirstListenTime(Carbon::createFromFormat("Y-m-d", $albumData['listenedAt'])),
                new Rating($albumData['rating'])
            );

            if ($album->getListenedAt()->isFromListeningPeriod($this->clock->mondayThisWeek())) {
                $albums[] = $album;
            }
        }

        return $albums;
    }
}
