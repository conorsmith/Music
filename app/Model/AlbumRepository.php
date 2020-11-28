<?php

namespace ConorSmith\Music\Model;

interface AlbumRepository
{
    public function find(AlbumId $id): ?Album;
    public function save(Album $album);
    public function update(Album $album): void;

    public function allByFirstListenTime();
    public function search($query);
    public function findForThisWeek();
}
