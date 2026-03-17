<?php

declare(strict_types=1);

use FFTTApi\FFTTApi;
use FFTTApi\Model\Epreuve\Individuelle\Classement;
use FFTTApi\Model\Epreuve\Individuelle\Groupe;
use FFTTApi\Model\Epreuve\Individuelle\Partie;
use FFTTApi\Tests\HttpClientMock;

beforeEach(function (): void {
    $this->api = FFTTApi::create(appId: '', appKey: '', serial: '1234', httpClient: HttpClientMock::class);
});

describe('[xml_result_indiv]', function (): void {
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

    it('devrait retourner un tableau vide si division non trouvée pour classement', function (): void {
        $result = $this->api->epreuveIndividuelle->recupererClassement(999999, 999999, 999999);

        expect($result)->toBeArray()->and($result)->toBeEmpty();
    });
});

describe('[xml_res_cla]', function (): void {
    it("devrait récupérer le classement d'une division de CF nouvelle formule", function (): void {
        $result = $this->api->epreuveIndividuelle->recupererClassementCriterium(1);

        expect($result)->toBeArray()
            ->and($result)->not->toBeEmpty()
            ->and($result[0])->toBeInstanceOf(Classement::class)
            ->and($result[0]->rang())->toBe(1);
    });

    it("devrait retourner un tableau vide si division non trouvée", function (): void {
        $result = $this->api->epreuveIndividuelle->recupererClassementCriterium(999999);

        expect($result)->toBeArray()->and($result)->toBeEmpty();
    });
});
