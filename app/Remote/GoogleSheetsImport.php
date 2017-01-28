<?php

namespace ConorSmith\Music\Remote;

use ConorSmith\Music\Model\Album;

class GoogleSheetsImport
{
    /**
     * @param array $unprocessedRows
     * @return GoogleSheetsImport
     */
    public static function fromUnprocessedRows(array $unprocessedRows)
    {
        $albums = [];
        $artists = [];
        $previousDate = false;
        
        $unprocessedRows = collect($unprocessedRows)
            ->reject(function ($row) {
                return is_null($row['Album']);
            })
            ->toArray();

        foreach ($unprocessedRows as $row) {
            if ($row['Week']) {
                $previousDate = $row['Week'];
            }

            if (array_key_exists($row['Artist'], $artists)) {
                $row['Artist'] = $artists[$row['Artist']];
            }

            $rating = array_get($row, 'Rating');

            if (is_null($rating) && array_key_exists('"Rating"', $row)) {
                $rating = $row['"Rating"'] * 2;
            }

            $album = Album::fromGoogleSheetsRow([
                'title'       => $row['Album'],
                'artist'      => $row['Artist'],
                'listened_at' => $previousDate,
                'year'        => array_get($row, 'Year'),
                'rating'      => $rating,
                'notes'       => array_get($row, 'Notes'),
            ]);

            if (is_string($row['Artist'])) {
                $artists[$row['Artist']] = $album->getArtist();
            }

            $albums[] = $album;
        }

        return new self($albums);
    }

    /**
     * @var Album[]
     */
    private $albums;

    /**
     * @param Album[] $albums
     */
    private function __construct(array $albums)
    {
        $this->albums = $albums;
    }

    /**
     * @return Album[]
     */
    public function getAlbums()
    {
        return $this->albums;
    }

    /**
     * @return array
     */
    public function getArtists()
    {
        $artists = [];

        foreach ($this->albums as $album) {
            $key = $album->getArtist()->getKey();

            if (!array_key_exists($key, $artists)) {
                $artists[$key] = [];
            }

            $artists[$key][] = $album;
        }

        return $artists;
    }
}
 
