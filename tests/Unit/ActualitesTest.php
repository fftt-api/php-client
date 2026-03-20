<?php

declare(strict_types=1);

use FFTTApi\FFTTApi;
use FFTTApi\Model\Divers\Actualite;
use FFTTApi\Tests\HttpClientMock;

beforeEach(function (): void {
    $this->api = FFTTApi::create(appId: '', appKey: '', serial: '', httpClient: HttpClientMock::class);
});

describe('[xml_new_actu]', function (): void {
    it(' devrait récupérer les dernières actualités de la fédération', function (): void {
        $actualites = $this->api->actualites->fluxActualitesFederation();

        expect($actualites)->toBeArray()
            ->and($actualites)->not->toBeEmpty()
            ->and($actualites[0])->toBeInstanceOf(Actualite::class)
            ->and($actualites[0]->titre())->toBe('Félix Lebrun triomphe à Chongqing et s’offre un deuxième WTT Champions')
            ->and($actualites[0]->date()->isValid())->toBeTrue();
    });
});
