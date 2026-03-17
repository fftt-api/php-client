<?php

declare(strict_types=1);

use FFTTApi\Enum\TypeEquipe;
use FFTTApi\FFTTApi;
use FFTTApi\Model\Club\Club;
use FFTTApi\Model\Club\DetailClub;
use FFTTApi\Model\Club\Equipe;
use FFTTApi\Tests\HttpClientMock;

beforeEach(function (): void {
    $this->api = FFTTApi::create(appId: '', appKey: '', serial: '1234', httpClient: HttpClientMock::class);
});

describe('[xml_club_dep2]', function (): void {
    it('devrait récupérer des clubs par leur département', function (): void {
        $result = $this->api->club->clubsParDepartement('16');

        expect($result)->toBeArray()
            ->and($result)->not->toBeEmpty()
            ->and($result[0])->toBeInstanceOf(Club::class)
            ->and($result[0]->numero())->toBe('10160237');
    });
});

describe('[xml_club_b]', function (): void {
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
});

describe('[xml_club_detail]', function (): void {
    it('devrait récupérer des clubs par un numéro', function (): void {
        $result = $this->api->club->detailClub('1');

        expect($result)->toBeInstanceOf(DetailClub::class)
            ->and($result->numero())->toBe('10160085');
    });
});

describe('[xml_equipe]', function (): void {
    it("devrait récupérer les équipes d'un club", function (): void {
        $result = $this->api->club->equipesClub('1', TypeEquipe::MASCULINE);

        expect($result)->toBeArray()
            ->and($result)->not->toBeEmpty()
            ->and($result[0])->toBeInstanceOf(Equipe::class)
            ->and($result[0]->idEquipe())->toBe(10998);
    });
});
