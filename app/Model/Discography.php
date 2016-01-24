<?php

namespace ConorSmith\Music\Model;

class Discography
{
    /**
     * @param array $albums
     * @return Discography
     */
    public static function fromAlbums(array $albums)
    {
        $invalidElements = collect($albums)
            ->reject(function ($album) {
                return $album instanceof Album;
            });

        if ($invalidElements->count() > 0) {
            throw new \InvalidArgumentException("The given array be a collection of Albums.");
        }

        $artists = collect($albums)
            ->map(function ($album) {
                return $album->getArtist();
            });

        if ($artists->unique()->count() !== 1) {
            throw new \InvalidArgumentException("The given Albums must all be by the same Artist.");
        }

        return new self($artists->pop(), $albums);
    }

    /**
     * @var Artist
     */
    private $artist;

    /**
     * @var array
     */
    private $albums;

    /**
     * @param Artist $artist
     * @param array  $albums
     */
    private function __construct(Artist $artist, array $albums)
    {
        $this->artist = $artist;
        $this->albums = $albums;
    }

    /**
     * @return Artist
     */
    public function getArtist()
    {
        return $this->artist;
    }

    /**
     * @return array
     */
    public function getAlbums()
    {
        return $this->albums;
    }
}
