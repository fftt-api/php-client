<?php

declare(strict_types=1);

use FFTTApi\Enum\TypeLicence;
use FFTTApi\FFTTApi;
use FFTTApi\Model\Joueur\DetailJoueur;
use FFTTApi\Model\Joueur\DetailJoueurBaseClassement;
use FFTTApi\Model\Joueur\DetailJoueurBaseSPID;
use FFTTApi\Model\Joueur\HistoriqueClassement;
use FFTTApi\Model\Joueur\JoueurBaseClassement;
use FFTTApi\Model\Joueur\JoueurBaseSPID;
use FFTTApi\Model\Partie\Partie;
use FFTTApi\Model\Partie\PartieBaseClassement;
use FFTTApi\Model\Partie\PartieBaseSPID;
use FFTTApi\Tests\HttpClientMock;

beforeEach(function (): void {
    $this->api = FFTTApi::create(appId: '', appKey: '', serial: '1234', httpClient: HttpClientMock::class);
});

describe('[xml_liste_joueur]', function (): void {
    it("devrait rechercher des joueurs par leur nom (base classement)", function (): void {
        $result = $this->api->joueur->joueursParNomSurBaseClassement('');

        expect($result)->toBeArray()
            ->and($result)->not->toBeEmpty()
            ->and($result[0])->toBeInstanceOf(JoueurBaseClassement::class)
            ->and($result[0]->licence())->toBe('6733567');
    });

    it('devrait rechercher des joueurs par leur club (base classement)', function (): void {
        $result = $this->api->joueur->joueursParClubSurBaseClassement('');

        expect($result)->toBeArray()
            ->and($result)->not->toBeEmpty()
            ->and($result[0])->toBeInstanceOf(JoueurBaseClassement::class)
            ->and($result[0]->licence())->toBe('167374');
    });
});

describe('[xml_liste_joueur_o]', function (): void {
    it('devrait rechercher des joueurs par leur nom (base SPID)', function (): void {
        $result = $this->api->joueur->joueursParNomSurBaseSPID('');

        expect($result)->toBeArray()
            ->and($result)->not->toBeEmpty()
            ->and($result[0])->toBeInstanceOf(JoueurBaseSPID::class)
            ->and($result[0]->licence())->toBe('552494');
    });

    it('devrait rechercher des joueurs par leur nom', function (): void {
        $result = $this->api->joueur->joueursParNom('');

        expect($result)->toBeArray()
            ->and($result)->not->toBeEmpty()
            ->and($result[0])->toBeInstanceOf(JoueurBaseSPID::class)
            ->and($result[0]->licence())->toBe('552494');
    });

    it('devrait rechercher des joueurs par leur club (base SPID)', function (): void {
        $result = $this->api->joueur->joueursParClubSurBaseSPID('');

        expect($result)->toBeArray()
            ->and($result)->not->toBeEmpty()
            ->and($result[0])->toBeInstanceOf(JoueurBaseSPID::class)
            ->and($result[0]->licence())->toBe('167376');
    });
});

describe('[xml_licence_b]', function (): void {
    it('devrait rechercher des joueurs par leur club', function (): void {
        $result = $this->api->joueur->joueursParClub('');

        expect($result)->toBeArray()
            ->and($result)->not->toBeEmpty()
            ->and($result[0])->toBeInstanceOf(DetailJoueur::class)
            ->and($result[0]->licence())->toBe('167376');
    });

    it('devrait rechercher des joueurs par leur club et leur type de licence', function (): void {
        $result = $this->api->joueur->joueursParClubEtType('', [TypeLicence::COMPETITION]);

        expect($result)->toBeArray()
            ->and($result)->not->toBeEmpty()
            ->and($result[0])->toBeInstanceOf(DetailJoueur::class)
            ->and($result[0]->licence())->toBe('167376')
            ->and($result[0]->typeLicence())->toBe(TypeLicence::COMPETITION);
    });

    it('devrait rechercher des joueurs par leur numéro de licence', function (): void {
        $result = $this->api->joueur->joueurParLicence('1');

        expect($result)
            ->toBeInstanceOf(DetailJoueur::class)
            ->and($result->licence())->toBe('1616528');
    });
});

describe('[xml_joueur]', function (): void {
    it('devrait rechercher des joueurs par leur numéro de licence (base classement)', function (): void {
        $result = $this->api->joueur->joueurParLicenceSurBaseClassement('1');

        expect($result)
            ->toBeInstanceOf(DetailJoueurBaseClassement::class)
            ->and($result->licence())->toBe('1610533');
    });
});

describe('[xml_licence]', function (): void {
    it('devrait rechercher des joueurs par leur numéro de licence (base SPID)', function (): void {
        $result = $this->api->joueur->joueurParLicenceSurBaseSPID('1');

        expect($result)
            ->toBeInstanceOf(DetailJoueurBaseSPID::class)
            ->and($result->licence())->toBe('1610533');
    });
});

describe('[xml_partie_mysql]', function (): void {
    it("devrait récupérer l'historique des parties d'un joueur (base classement)", function (): void {
        $result = $this->api->joueur->historiquePartiesBaseClassement('1');

        expect($result)->toBeArray()
            ->and($result)->not->toBeEmpty()
            ->and($result[0])->toBeInstanceOf(PartieBaseClassement::class)
            ->and($result[0]->licence())->toBe('1616638');
    });
});

describe('[xml_partie]', function (): void {
    it("devrait récupérer l'historique des parties d'un joueur (base SPID)", function (): void {
        $result = $this->api->joueur->historiquePartiesBaseSPID('1');

        expect($result)->toBeArray()
            ->and($result)->not->toBeEmpty()
            ->and($result[0])->toBeInstanceOf(PartieBaseSPID::class)
            ->and($result[0]->partieId())->toBe(12434534);
    });

    it("devrait récupérer l'historique des parties d'un joueur", function (): void {
        $result = $this->api->joueur->historiqueParties('1');

        expect($result)->toBeArray()
            ->and($result)->not->toBeEmpty()
            ->and($result[0])->toBeInstanceOf(Partie::class)
            ->and($result[0]->partieId())->toBe(12434534);
    });

    it("devrait récupérer les parties validées d'un joueur", function (): void {
        $result = $this->api->joueur->partiesValidees('1');

        expect($result)->toBeArray()
            ->and($result)->toHaveCount(15)
            ->and($result[0])->toBeInstanceOf(Partie::class);
    });

    it("devrait récupérer les parties non-validées d'un joueur", function (): void {
        $result = $this->api->joueur->partiesNonValidees('1');

        expect($result)->toBeArray()
            ->and($result)->toHaveCount(16)
            ->and($result[0])->toBeInstanceOf(Partie::class);
    });

    it("devrait calculer les points virtuels des parties non-validées d'un joueur", function (): void {
        $result = $this->api->joueur->pointsVirtuels('1');

        expect($result)->toBe(-104.0);
    });

    it("devrait calculer les points virtuels des parties non-validées d'un joueur sur une période donnée", function (): void {
        $result = $this->api->joueur->pointsVirtuelsSurPeriode('1', '15/03/2026', '15/03/2026');

        expect($result)->toBe(-87.0);
    });
});

describe('[xml_histo_classement]', function (): void {
    it("devrait récupérer l'historique de classement d'un joueur", function (): void {
        $result = $this->api->joueur->historiqueClassementOfficiel('1');

        expect($result)->toBeArray()
            ->and($result[0])->toBeInstanceOf(HistoriqueClassement::class)
            ->and($result[0]->pointsOfficiels())->toBe(500.0);
    });
});
