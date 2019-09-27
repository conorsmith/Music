<?php

namespace ConorSmith\Music\Model;

interface AlbumRepository
{
    public function save(Album $album);
    public function destroy();

    public function allByFirstListenTime();
    public function findForThisWeek();
}
