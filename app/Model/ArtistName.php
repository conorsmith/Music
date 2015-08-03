<?php

namespace ConorSmith\Music\Model;

class ArtistName
{
    /**
     * @param string $name
     * @return ArtistName
     */
    public static function fromString($name)
    {
        if (!is_string($name)) {
            throw new \InvalidArgumentException(sprintf(
                "The value for an Artist Name must be a string, %s given.",
                gettype($name)
            ));
        }

        return new self($name);
    }

    /**
     * @var string
     */
    private $name;

    /**
     * @param mixed $name Will be cast to a string, which cannot be empty
     */
    private function __construct($name)
    {
        $name = strval($name);

        if ($name === "") {
            throw new \DomainException("An Artist Name cannot be blank.");
        }

        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }
}
 