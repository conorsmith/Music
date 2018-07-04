<?php

namespace ConorSmith\Music\Model;

use Carbon\Carbon;

class FirstListenTime
{
    /**
     * @param string $dateAsString
     * @return FirstListenTime
     */
    public static function fromDateAsString($dateAsString)
    {
        return new self(Carbon::createFromFormat('d/m/Y', $dateAsString));
    }

    /**
     * @var Carbon
     */
    private $date;

    /**
     * @param Carbon $date
     */
    private function __construct(Carbon $date)
    {
        $this->date = $date;
    }

    /**
     * @return Carbon
     */
    public function getDate()
    {
        return $this->date;
    }

    public function isFromListeningPeriod(Carbon $listeningPeriod)
    {
        return $this->date->year === $listeningPeriod->year
            && $this->date->month === $listeningPeriod->month
            && $this->date->day === $listeningPeriod->day;
    }
}
 