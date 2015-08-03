<?php

namespace ConorSmith\Music\Model;

class NullReleaseDate extends ReleaseDate
{
    public static function create()
    {
        return new self;
    }

    private function __construct()
    {
        //
    }

    public function getValue()
    {
        return null;
    }
}
