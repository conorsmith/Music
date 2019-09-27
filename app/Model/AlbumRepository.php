<?php

namespace ConorSmith\Music\Model;

interface AlbumRepository
{
    public function saveAll(array $albums);
    public function destroy();

    public function allByFirstListenTime();
    public function findForThisWeek();
}
