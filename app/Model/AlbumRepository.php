<?php

namespace ConorSmith\Music\Model;

interface AlbumRepository
{
    public function save(array $albums);
    public function destroy();

    public function allByFirstListenTime();
}
