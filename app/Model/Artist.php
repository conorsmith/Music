<?php

namespace ConorSmith\Music\Model;

class Artist
{
    /**
     * @param $name
     * @return Artist
     */
    public static function fromName($name)
    {
        return new self(
            ArtistId::generate(),
            ArtistName::fromString($name)
        );
    }

    /**
     * @var ArtistId
     */
    private $id;

    /**
     * @var ArtistName
     */
    private $name;

    /**
     * @param ArtistId   $id
     * @param ArtistName $name
     */
    public function __construct(ArtistId $id, ArtistName $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * @return ArtistId
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return ArtistName
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return strval($this->id);
    }
}
 