<?php

namespace ConorSmith\Music\Model;

class Album
{
    /**
     * @param array $row
     * @return Album
     */
    public static function fromGoogleSheetsRow(array $row)
    {
        return new self(
            AlbumId::generate(),
            AlbumTitle::fromString($row['title']),
            $row['artist'] instanceof Artist ? $row['artist'] : Artist::fromName($row['artist']),
            is_null($row['year']) ? NullReleaseDate::create() : ReleaseDate::fromYearAsString($row['year']),
            FirstListenTime::fromDateAsString($row['listened_at']),
            Rating::fromString($row['rating'])
        );
    }

    /**
     * @var AlbumId
     */
    private $id;

    /**
     * @var AlbumTitle
     */
    private $title;

    /**
     * @var Artist
     */
    private $artist;

    /**
     * @var ReleaseDate
     */
    private $releaseDate;

    /**
     * @var FirstListenTime
     */
    private $listenedAt;

    /**
     * @var Rating
     */
    private $rating;

    /**
     * @param AlbumId         $id
     * @param AlbumTitle      $title
     * @param Artist          $artist
     * @param ReleaseDate     $releaseDate
     * @param FirstListenTime $listenedAt
     * @param Rating          $rating
     */
    private function __construct(
        AlbumId $id,
        AlbumTitle $title,
        Artist $artist,
        ReleaseDate $releaseDate,
        FirstListenTime $listenedAt,
        Rating $rating
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->artist = $artist;
        $this->releaseDate = $releaseDate;
        $this->listenedAt = $listenedAt;
        $this->rating = $rating;
    }

    /**
     * @return AlbumId
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return AlbumTitle
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return Artist
     */
    public function getArtist()
    {
        return $this->artist;
    }

    /**
     * @return ReleaseDate
     */
    public function getReleaseDate()
    {
        return $this->releaseDate;
    }

    /**
     * @return FirstListenTime
     */
    public function getListenedAt()
    {
        return $this->listenedAt;
    }

    public function getRating()
    {
        return $this->rating;
    }
}
 