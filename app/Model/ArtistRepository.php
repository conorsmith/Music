<?php

namespace ConorSmith\Music\Model;

interface ArtistRepository
{
    public function findByName(ArtistName $name): ?Artist;
}
