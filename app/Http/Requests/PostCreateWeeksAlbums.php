<?php

namespace ConorSmith\Music\Http\Requests;

use Carbon\Carbon;
use DateTime;
use Exception;

class PostCreateWeeksAlbums
{
    /** @var DateTime */
    private $week;

    /** @var array */
    private $albums;

    public function __construct(string $week, array $artists, array $albums, array $releaseDates)
    {
        if (count($artists) !== 5
            || count($albums) !== 5
            || count($releaseDates) !== 5
        ) {
            throw new Exception;
        }

        $this->week = Carbon::createFromFormat("Y-m-d", $week);

        $this->albums = [];

        for ($i = 0; $i < 5; $i++) {
            $this->albums[] = new Album($artists[$i], $albums[$i], intval($releaseDates[$i]));
        }
    }

    public function getWeek(): DateTime
    {
        return $this->week;
    }

    public function getAlbums(): array
    {
        return $this->albums;
    }
}
