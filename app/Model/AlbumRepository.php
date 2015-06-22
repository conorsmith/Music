<?php

namespace ConorSmith\Music\Model;

interface AlbumRepository
{
    public function all();
    public function save(array $albums);
    public function destroy();
}
