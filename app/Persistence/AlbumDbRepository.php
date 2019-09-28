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
use ConorSmith\Music\Model\Discography;
use ConorSmith\Music\Model\DiscographyRepository;
use ConorSmith\Music\Model\FirstListenTime;
use ConorSmith\Music\Model\NullReleaseDate;
use ConorSmith\Music\Model\Rating;
use ConorSmith\Music\Model\ReleaseDate;
use ConorSmith\Music\Remote\ImportRepository;
use Illuminate\Database\Connection;
use Rhumsaa\Uuid\Uuid;

class AlbumDbRepository implements AlbumRepository, DiscographyRepository, ImportRepository
{
    /** @var Connection */
    private $db;

    /** @var Clock */
    private $clock;

    public function __construct(Connection $db, Clock $clock)
    {
        $this->db = $db;
        $this->clock = $clock;
    }

    public function find(AlbumId $id): ?Album
    {
        $row = $this->db->selectOne(
            "
                SELECT albums.*, artists.name AS artist_name
                FROM albums JOIN artists ON albums.artist_id = artists.id
                WHERE albums.id = ?
            ",
            [
                $id->__toString(),
            ]
        );

        if (is_null($row)) {
            return null;
        }

        return $this->createAlbumFromRow($row);
    }

    public function save(Album $album)
    {
        $this->db->transaction(function () use ($album) {

            $artistRow = $this->db->selectOne(
                "SELECT * FROM artists WHERE id = ?",
                [
                    $album->getArtist()->getId()->__toString(),
                ]
            );

            if (is_null($artistRow)) {
                $this->db->insert(
                    "INSERT INTO artists (id, name, created_at) VALUES (?, ?, ?)",
                    [
                        $album->getArtist()->getId()->__toString(),
                        $album->getArtist()->getName()->__toString(),
                        $this->clock->now()->format("Y-m-d H:i:s"),
                    ]
                );
            }

            $this->db->insert(
                "INSERT INTO albums (id, title, artist_id, release_date, listened_at, rating, created_at) VALUES (?, ?, ?, ?, ?, ?, ?)",
                [
                    $album->getId()->__toString(),
                    $album->getTitle()->__toString(),
                    $album->getArtist()->getId()->__toString(),
                    $album->getReleaseDate()->getValue(),
                    $album->getListenedAt()->getDate()->format("Y-m-d"),
                    $album->getRating()->getValue(),
                    $this->clock->now()->format("Y-m-d H:i:s"),
                ]
            );
        });
    }

    public function update(Album $album): void
    {
        $this->db->update(
            "
                UPDATE albums
                SET title = ?,
                    artist_id = ?,
                    release_date = ?,
                    listened_at = ?,
                    rating = ?,
                    was_imported_from_google_sheets = 0
                WHERE id = ?
            ",
            [
                $album->getTitle()->__toString(),
                $album->getArtist()->getId()->__toString(),
                $album->getReleaseDate()->getValue(),
                $album->getListenedAt()->getDate()->format("Y-m-d"),
                $album->getRating()->getValue(),
                $album->getId()->__toString(),
            ]
        );
    }

    public function markAllAlbumsAsImported(): void
    {
        $this->db->update(
            "UPDATE albums SET was_imported_from_google_sheets = 1"
        );
    }

    public function deleteAllImportedAlbums(): void
    {
        $this->db->delete("
            DELETE FROM artists
            WHERE id IN
            (
                SELECT artist_id
                FROM albums
                GROUP BY artist_id
                HAVING MIN(was_imported_from_google_sheets) = 1
            )
        ");

        $this->db->delete("DELETE FROM albums WHERE was_imported_from_google_sheets = 1");
    }

    public function allByFirstListenTime()
    {
        $rows = $this->db->select(
            "
                SELECT albums.*, artists.name AS artist_name
                FROM albums JOIN artists ON albums.artist_id = artists.id
                ORDER BY albums.listened_at DESC,
                    artists.name ASC
            "
        );

        $albums = [];

        foreach ($rows as $row) {
            $albums[] = $this->createAlbumFromRow($row);
        }

        return $albums;
    }

    public function findForThisWeek()
    {
        $albums = $this->allByFirstListenTime();

        $thisWeeksAlbums = [];

        foreach ($albums as $album) {
            if ($album->getListenedAt()->isFromListeningPeriod($this->clock->mondayThisWeek())) {
                $thisWeeksAlbums[] = $album;
            }
        }

        return $thisWeeksAlbums;
    }

    public function allByArtistName()
    {
        $rows = $this->db->select(
            "
                SELECT albums.*, artists.name AS artist_name
                FROM albums JOIN artists ON albums.artist_id = artists.id
                ORDER BY artists.name ASC,
                    albums.release_date ASC
            "
        );

        $albumsByArtist = [];

        foreach ($rows as $row) {
            if (!array_key_exists($row['artist_id'], $albumsByArtist)) {
                $albumsByArtist[$row['artist_id']] = [];
            }

            $albumsByArtist[$row['artist_id']][] = $this->createAlbumFromRow($row);
        }

        $discographies = [];

        foreach ($albumsByArtist as $albums) {
            $discographies[] = Discography::fromAlbums($albums);
        }

        return $discographies;
    }

    private function createAlbumFromRow(array $row): Album
    {
        return new Album(
            new AlbumId(Uuid::fromString($row['id'])),
            AlbumTitle::fromString($row['title']),
            new Artist(
                new ArtistId(Uuid::fromString($row['artist_id'])),
                ArtistName::fromString($row['artist_name'])
            ),
            is_null($row['release_date'])
                ? NullReleaseDate::create()
                : new ReleaseDate($row['release_date']),
            new FirstListenTime(Carbon::createFromFormat("Y-m-d", $row['listened_at'])),
            new Rating($row['rating'])
        );
    }
}
