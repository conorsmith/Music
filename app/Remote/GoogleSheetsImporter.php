<?php

namespace ConorSmith\Music\Remote;

use Carbon\Carbon;

class GoogleSheetsImporter
{
    public function importRows(array $rows)
    {
        $albums = [];
        $artists = [];
        $previousDate = false;

        foreach ($rows as $row) {
            if ($row['Week']) {
                //$previousDate = Carbon::createFromFormat('d/M/Y', trim($row['Week']));
                $previousDate = $row['Week'];
            }

            $album = [
                'title' => $row['Album'],
                'artist' => $row['Artist'],
                'listened_at' => $previousDate,
                'year' => array_get($row, 'Year'),
            ];

            $albums[] = $album;

            if (!array_key_exists($album['artist'], $artists)) {
                $artists[$album['artist']] = [];
            }

            $artists[$album['artist']][] = $album;
        }

        uasort($artists, function ($a, $b) {
            return strcasecmp($a[0]['artist'], $b[0]['artist']);
        });

        return ['artists' => $artists, 'albums' => array_reverse($albums)];
    }
}
