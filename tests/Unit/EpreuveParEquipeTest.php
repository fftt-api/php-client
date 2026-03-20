<?php

declare(strict_types=1);

use FFTTApi\FFTTApi;
use FFTTApi\Model\Epreuve\ParEquipes\Poule\EquipePoule;
use FFTTApi\Model\Epreuve\ParEquipes\Poule\Poule;
use FFTTApi\Model\Epreuve\ParEquipes\Rencontre\DetailRencontre;
use FFTTApi\Model\Epreuve\ParEquipes\Rencontre\Rencontre;
use FFTTApi\Tests\HttpClientMock;

beforeEach(function (): void {
    $this->api = FFTTApi::create(appId: '', appKey: '', serial: '1234', httpClient: HttpClientMock::class);
});

describe('[xml_result_equ]', function (): void {
    it("devrait récupérer les poules d'une division", function (): void {
        $result = $this->api->epreuveParEquipe->poulesPourDivision(123);

        expect($result)->toBeArray()
            ->and($result)->not->toBeEmpty()
            ->and($result[0])->toBeInstanceOf(Poule::class)
            ->and($result[0]->libelle())->toBe('Poule 1');
    });

    it("devrait récupérer les rencontres d'une poule", function (): void {
        $result = $this->api->epreuveParEquipe->rencontresPourPoule(123, 456);

        expect($result)->toBeArray()
            ->and($result)->not->toBeEmpty()
            ->and($result[0])->toBeInstanceOf(Rencontre::class)
            ->and($result[0]->libelle())->toBe('Poule 2 - tour n°1 du 13/09/2025');
    });

    it("devrait récupérer les équipes d'une poule dans l'ordre de départ", function (): void {
        $result = $this->api->epreuveParEquipe->ordrePoule(123, 456);

        expect($result)->toBeArray()
            ->and($result)->not->toBeEmpty()
            ->and($result[0])->toBeInstanceOf(EquipePoule::class)
            ->and($result[0]->idEquipe())->toBe(1590);
    });

    it("devrait récupérer le classement d'une poule", function (): void {
        $result = $this->api->epreuveParEquipe->classementPoule(123, 456);

        expect($result)->toBeArray()
            ->and($result)->not->toBeEmpty()
            ->and($result[0])->toBeInstanceOf(EquipePoule::class)
            ->and($result[0]->idEquipe())->toBe(1904);
    });
});

describe('[xml_chp_renc]', function (): void {
    it("devrait récupérer le détail d'une rencontre classique", function (): void {
        $result = $this->api->epreuveParEquipe->detailRencontre(123456);

        expect($result)
            ->toBeInstanceOf(DetailRencontre::class)
            ->and($result->resultat()->equipeA())->toBe('Chateaubernard 3')
            ->and($result->resultat()->equipeB())->toBe('Vars EP 1');
    });

    it("devrait récupérer le détail d'une rencontre avec des joueurs numérotés", function (): void {
        $result = $this->api->epreuveParEquipe->detailRencontre(987654);

        expect($result)
            ->toBeInstanceOf(DetailRencontre::class)
            ->and($result->resultat()->equipeA())->toBe('ROMANS ASPTT 1')
            ->and($result->resultat()->equipeB())->toBe('LA ROMAGNE SS 2');
    });

    it("devrait retourner null si aucune rencontre trouvée", function (): void {
        $result = $this->api->epreuveParEquipe->detailRencontre(999999);

        expect($result)->toBeNull();
    });
});
