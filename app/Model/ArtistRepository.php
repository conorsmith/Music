<?php

namespace ConorSmith\Music\Model;

interface ArtistRepository
{
    public function findByName(string $name): ?Artist;
}
