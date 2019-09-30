<?php

namespace ConorSmith\Music\Http\Requests;

class Album
{
    /** @var string */
    private $artistName;

    /** @var string */
    private $title;

    /** @var int */
    private $releaseDate;

    public function __construct(string $artistName, string $title, int $releaseDate)
    {
        $this->artistName = $artistName;
        $this->title = $title;
        $this->releaseDate = $releaseDate;
    }

    public function getArtistName(): string
    {
        return $this->artistName;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getReleaseDate(): int
    {
        return $this->releaseDate;
    }
}
