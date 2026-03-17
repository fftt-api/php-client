<?php

declare(strict_types=1);

use FFTTApi\FFTTApi;
use FFTTApi\Model\Divers\Actualite;
use FFTTApi\Tests\HttpClientMock;

beforeEach(function (): void {
    $this->api = FFTTApi::create(appId: '', appKey: '', serial: '', httpClient: HttpClientMock::class);
});

it('devrait récupérer les dernières actualités de la fédération', function (): void {
    $actualites = $this->api->actualites->fluxActualitesFederation();

    expect($actualites)->toBeArray()
        ->and($actualites)->not->toBeEmpty()
        ->and($actualites[0])->toBeInstanceOf(Actualite::class)
        ->and($actualites[0]->date()->isValid())->toBeTrue();
});
