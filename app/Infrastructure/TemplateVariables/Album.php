<?php

namespace ConorSmith\Music\Infrastructure\TemplateVariables;

use ConorSmith\Music\Model\Album as DomainModel;
use ConorSmith\Music\Model\Artist;

final class Album
{
    public static function present(DomainModel $album): self
    {
        $variable = new self;
        $variable->id = strval($album->getId());
        $variable->title = strval($album->getTitle());
        $variable->artist = strval($album->getArtist()->getName());
        $variable->listenedAt = $album->getListenedAt()->getDate()->format('d/m/Y');
        $variable->year = strval($album->getReleaseDate()->getValue());
        $variable->rating = $album->getRating()->getValue();
        $variable->artistColour = self::findColourForArtist($album->getArtist());
        return $variable;
    }

    public $id;
    public $title;
    public $artist;
    public $listenedAt;
    public $year;
    public $rating;
    public $artistColour;

    private static function findColourForArtist(Artist $artist)
    {
        $classesByLetter = [
            'a' => "material-red",
            'b' => "material-red",
            'c' => "material-pink",
            'd' => "material-pink",
            'e' => "material-purple",
            'f' => "material-purple",
            'g' => "material-deeppurple",
            'h' => "material-deeppurple",
            'i' => "material-indigo",
            'j' => "material-indigo",
            'k' => "material-lightblue",
            'l' => "material-lightblue",
            'm' => "material-cyan",
            'n' => "material-cyan",
            'o' => "material-teal",
            'p' => "material-teal",
            'q' => "success",
            'r' => "success",
            's' => "material-lightgreen",
            't' => "material-lightgreen",
            'u' => "material-lime",
            'v' => "material-lime",
            'w' => "material-lightyellow",
            'x' => "material-lightyellow",
            'y' => "material-orange",
            'z' => "material-orange",
        ];

        $artistFirstLetter = strtolower(substr($artist->getName(), 0, 1));

        if (!array_key_exists($artistFirstLetter, $classesByLetter)) {
            return "material-red";
        }

        return $classesByLetter[$artistFirstLetter];
    }
}
