<?php

namespace ConorSmith\Music\Model;

use Rhumsaa\Uuid\Uuid;

trait IsIdentifier
{
    public static function generate()
    {
        return new self(Uuid::uuid4());
    }

    /**
     * @var Uuid
     */
    private $uuid;

    /**
     * @param Uuid $uuid
     */
    private function __construct(Uuid $uuid)
    {
        $this->uuid = $uuid;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->uuid->toString();
    }
}
 