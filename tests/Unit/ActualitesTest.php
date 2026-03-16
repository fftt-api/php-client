<?php

declare(strict_types=1);

use FFTTApi\Core\HttpClientMock;
use FFTTApi\FFTTApi;
use FFTTApi\Model\Divers\Actualite;

beforeEach(function (): void {
    $this->api = FFTTApi::create('', '', '', new HttpClientMock);
});

it('devrait récupérer les dernières actualités de la fédération', function (): void {
    $actualites = $this->api->actualites->fluxActualitesFederation();

    expect($actualites)->toBeArray()
        ->and($actualites)->not->toBeEmpty()
        ->and($actualites[0])->toBeInstanceOf(Actualite::class)
        ->and($actualites[0]->date()->isValid())->toBeTrue();
});
