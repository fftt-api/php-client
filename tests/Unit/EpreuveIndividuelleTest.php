<?php

declare(strict_types=1);

use FFTTApi\FFTTApi;
use FFTTApi\Model\Epreuve\Individuelle\Classement;
use FFTTApi\Model\Epreuve\Individuelle\Groupe;
use FFTTApi\Model\Epreuve\Individuelle\Partie;
use FFTTApi\Tests\HttpClientMock;

beforeEach(function (): void {
    $this->api = FFTTApi::create('', '', '', new HttpClientMock);
});

it("devrait récupérer les groupes d'une division", function (): void {
    $result = $this->api->epreuveIndividuelle->rechercherGroupes(123, 456);

    expect($result)->toBeArray()
        ->and($result)->not->toBeEmpty()
        ->and($result[0])->toBeInstanceOf(Groupe::class)
        ->and($result[0]->libelle())->toBe('T4 Gr1');
});

it("devrait récupérer les parties d'une division", function (): void {
    $result = $this->api->epreuveIndividuelle->recupererParties(123, 456);

    expect($result)->toBeArray()
        ->and($result)->not->toBeEmpty()
        ->and($result[0])->toBeInstanceOf(Partie::class)
        ->and($result[0]->libelle())->toBe('Finale');
});

it("devrait récupérer le classement d'une division", function (): void {
    $result = $this->api->epreuveIndividuelle->recupererClassement(123, 456);

    expect($result)->toBeArray()
        ->and($result)->not->toBeEmpty()
        ->and($result[0])->toBeInstanceOf(Classement::class)
        ->and($result[0]->pointsCriterium())->toBe('150A');
});

it("devrait récupérer le classement d'une division de CF nouvelle formule", function (): void {
    $result = $this->api->epreuveIndividuelle->recupererClassementCriterium(123);

    expect($result)->toBeArray()
        ->and($result)->not->toBeEmpty()
        ->and($result[0])->toBeInstanceOf(Classement::class)
        ->and($result[0]->pointsCriterium())->toBe('150A');
});
