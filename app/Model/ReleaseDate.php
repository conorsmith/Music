<?php

namespace ConorSmith\Music\Model;

class ReleaseDate
{
    /**
     * @param string $yearAsString
     * @return ReleaseDate
     */
    public static function fromYearAsString($yearAsString)
    {
        return new self(intval($yearAsString));
    }

    /**
     * @var int
     */
    private $year;

    /**
     * @param int $year
     */
    public function __construct($year)
    {
        if ($year < 1900) {
            throw new \DomainException(
                sprintf("Cop on, %s? What are you listening to released pre-1900?", $year)
            );
        }

        $this->year = $year;
    }

    /**
     * @return int
     */
    public function getValue()
    {
        return $this->year;
    }
}
 