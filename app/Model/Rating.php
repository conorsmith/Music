<?php

namespace ConorSmith\Music\Model;

class Rating
{
    public static function fromString($valueAsString)
    {
        return new self($valueAsString);
    }

    private $value;

    private function __construct($value)
    {
        $this->value = intval($value);
    }

    public function getValue()
    {
        return $this->value;
    }
}
