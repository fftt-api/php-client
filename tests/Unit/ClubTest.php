<?php

declare(strict_types=1);

use FFTTApi\Core\HttpClientMock;
use FFTTApi\Enum\TypeEquipe;
use FFTTApi\FFTTApi;
use FFTTApi\Model\Club\Club;
use FFTTApi\Model\Club\DetailClub;
use FFTTApi\Model\Club\Equipe;

beforeEach(function (): void {
    $this->api = FFTTApi::create('', '', '', new HttpClientMock);
});

it('devrait récupérer des clubs par leur département', function (): void {
    $result = $this->api->club->clubsParDepartement('16');

    expect($result)->toBeArray()
        ->and($result)->not->toBeEmpty()
        ->and($result[0])->toBeInstanceOf(Club::class)
        ->and($result[0]->numero())->toBe('10160237');
});

it("devrait récupérer des clubs par code postal", function (): void {
    $result = $this->api->club->clubsParCodePostal('16120');

    expect($result)->toBeArray()
        ->and($result)->not->toBeEmpty()
        ->and($result[0])->toBeInstanceOf(Club::class)
        ->and($result[0]->numero())->toBe('10330035');
});

it('devrait récupérer des clubs par ville', function (): void {
    $result = $this->api->club->clubsParVille('bordeaux');

    expect($result)->toBeArray()
        ->and($result)->not->toBeEmpty()
        ->and($result[0])->toBeInstanceOf(Club::class)
        ->and($result[0]->numero())->toBe('08751412');
});

it('devrait récupérer des clubs par un nom', function (): void {
    $result = $this->api->club->clubsParNom('ping');

    expect($result)->toBeArray()
        ->and($result)->not->toBeEmpty()
        ->and($result[0])->toBeInstanceOf(Club::class)
        ->and($result[0]->numero())->toBe('08751412');
});

it('devrait récupérer des clubs par un numéro', function (): void {
    $result = $this->api->club->detailClub('10160085');

    expect($result)->toBeInstanceOf(DetailClub::class)
        ->and($result->numero())->toBe('10160085');
});

it("devrait récupérer les équipes d'un club", function (): void {
    $result = $this->api->club->equipesClub('10160051', TypeEquipe::MASCULINE);

    expect($result)->toBeArray()
        ->and($result)->not->toBeEmpty()
        ->and($result[0])->toBeInstanceOf(Equipe::class)
        ->and($result[0]->idEquipe())->toBe(10998);
});
