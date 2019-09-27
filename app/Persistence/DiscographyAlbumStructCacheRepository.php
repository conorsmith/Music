<?php

namespace ConorSmith\Music\Persistence;

use Carbon\Carbon;
use ConorSmith\Music\Model\Album;
use ConorSmith\Music\Model\AlbumId;
use ConorSmith\Music\Model\AlbumTitle;
use ConorSmith\Music\Model\Artist;
use ConorSmith\Music\Model\ArtistId;
use ConorSmith\Music\Model\ArtistName;
use ConorSmith\Music\Model\Discography;
use ConorSmith\Music\Model\DiscographyRepository;
use ConorSmith\Music\Model\FirstListenTime;
use ConorSmith\Music\Model\NullReleaseDate;
use ConorSmith\Music\Model\Rating;
use ConorSmith\Music\Model\ReleaseDate;
use Illuminate\Contracts\Cache\Repository;
use Rhumsaa\Uuid\Uuid;

class DiscographyAlbumStructCacheRepository implements DiscographyRepository
{
    private $cache;

    public function __construct(Repository $cache)
    {
        $this->cache = $cache;
    }

    public function allByArtistName()
    {
        $albumIndex = $this->cache->get(AlbumStructCacheRepository::ALBUM_INDEX_KEY);

        if (!is_array($albumIndex)) {
            return [];
        }

        $albumsByArtist = [];

        foreach ($albumIndex as $albumId) {
            $album = $this->reconstituteAlbum(
                $this->cache->get($albumId)
            );

            $artistId = $album->getArtist()->getId()->__toString();

            if (!array_key_exists($artistId, $albumsByArtist)) {
                $albumsByArtist[$artistId] = [];
            }

            $albumsByArtist[$artistId][] = $album;
        }

        $discographies = [];

        foreach ($albumsByArtist as $artistId => $albums) {
            $albums = array_reverse($albums);
            usort($albums, function ($a, $b) {
                return strcasecmp(
                    $a->getReleaseDate()->getValue(),
                    $b->getReleaseDate()->getValue()
                );
            });

            $discographies[] = Discography::fromAlbums($albums);
        }

        usort($discographies, function ($a, $b) {
            return strcasecmp(
                $a->getArtist()->getName(),
                $b->getArtist()->getName()
            );
        });

        return $discographies;
    }

    private function reconstituteAlbum(array $albumData): Album
    {
        return new Album(
            new AlbumId(Uuid::fromString($albumData['id'])),
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
    }
}
