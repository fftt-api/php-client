<?php

declare(strict_types=1);

namespace FFTTApi\Model\Divers;

use Carbon\Carbon;
use FFTTApi\Model\CanSerialize;
use FFTTApi\Util\DateTimeUtils;

final readonly class Actualite implements CanSerialize
{
    private Carbon $date;

    private string $titre;

    private string $description;

    private string $url;

    private string $photo;

    private string $categorie;

    public static function fromArray(array $data): self
    {
        $model = new self;

        $model->date = DateTimeUtils::date($data['date']);
        $model->titre = $data['titre'];
        $model->description = $data['description'];
        $model->url = $data['url'];
        $model->photo = $data['photo'];
        $model->categorie = $data['categorie'];

        return $model;
    }

    public function date(): Carbon
    {
        return $this->date;
    }

    public function titre(): string
    {
        return $this->titre;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function url(): string
    {
        return $this->url;
    }

    public function photo(): string
    {
        return $this->photo;
    }

    public function categorie(): string
    {
        return $this->categorie;
    }
}
