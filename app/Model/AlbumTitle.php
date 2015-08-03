<?php

namespace ConorSmith\Music\Model;

class AlbumTitle
{
    /**
     * @param string $title
     * @return AlbumTitle
     */
    public static function fromString($title)
    {
        if (!is_string($title)) {
            throw new \InvalidArgumentException(sprintf(
                "The value for an Album Title must be a string, %s given.",
                gettype($title)
            ));
        }

        return new self($title);
    }

    /**
     * @var string
     */
    private $title;

    /**
     * @param mixed $title Will be cast to a string, which cannot be empty
     */
    private function __construct($title)
    {
        $title = strval($title);

        if ($title === "") {
            throw new \DomainException("An Album Title cannot be blank.");
        }

        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->title;
    }
}
 