<?php

namespace ConorSmith\Music\Model;

interface AlbumRepository
{
    public function saveAll(array $albums);
    public function save(Album $album);
    public function destroy();

    public function allByFirstListenTime();
    public function findForThisWeek();
}
