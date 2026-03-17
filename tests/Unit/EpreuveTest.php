<?php

declare(strict_types=1);

use FFTTApi\Enum\TypeEpreuve;
use FFTTApi\FFTTApi;
use FFTTApi\Model\Epreuve\Division;
use FFTTApi\Model\Epreuve\Epreuve;
use FFTTApi\Tests\HttpClientMock;

beforeEach(function (): void {
    $this->api = FFTTApi::create('', '', '', new HttpClientMock);
});

it("devrait récupérer la liste des épreuves", function (): void {
    $result = $this->api->epreuve->rechercherEpreuves(123, TypeEpreuve::AUTRE_EPREUVE_INDIVIDUELLE);

    expect($result)->toBeArray()
        ->and($result)->not->toBeEmpty()
        ->and($result[0])->toBeInstanceOf(Epreuve::class)
        ->and($result[0]->idEpreuve())->toBe(256);
});

it("devrait récupérer les divisions d'une épreuve", function (): void {
    $result = $this->api->epreuve->rechercherDivisionsPourEpreuve(123, 456, TypeEpreuve::AUTRE_EPREUVE_INDIVIDUELLE);

    expect($result)->toBeArray()
        ->and($result)->not->toBeEmpty()
        ->and($result[0])->toBeInstanceOf(Division::class)
        ->and($result[0]->id())->toBe(196680);
});
