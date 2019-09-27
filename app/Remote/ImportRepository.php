<?php

namespace ConorSmith\Music\Remote;

interface ImportRepository
{
    public function markAllAlbumsAsImported(): void;
    public function deleteAllImportedAlbums(): void;
}
