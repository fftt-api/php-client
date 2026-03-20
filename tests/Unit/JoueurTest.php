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

    it('devrait retourner un tableau vide si aucun joueur trouvé nom (base classement)', function (): void {
        $result = $this->api->joueur->joueursParNomSurBaseClassement('999999');

        expect($result)->toBeArray()->and($result)->toBeEmpty();
    });

    it('devrait rechercher des joueurs par leur club (base classement)', function (): void {
        $result = $this->api->joueur->joueursParClubSurBaseClassement('');

        expect($result)->toBeArray()
            ->and($result)->not->toBeEmpty()
            ->and($result[0])->toBeInstanceOf(JoueurBaseClassement::class)
            ->and($result[0]->licence())->toBe('167374');
    });

    it('devrait retourner un tableau vide si aucun joueur trouvé par club (base classement)', function (): void {
        $result = $this->api->joueur->joueursParClubSurBaseClassement('999999');

        expect($result)->toBeArray()->and($result)->toBeEmpty();
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

    it('devrait retourner un tableau vide si aucun joueur trouvé par nom (base SPID)', function (): void {
        $result = $this->api->joueur->joueursParNomSurBaseSPID('999999');

        expect($result)->toBeArray()->and($result)->toBeEmpty();
    });

    it('devrait rechercher des joueurs par leur nom', function (): void {
        $result = $this->api->joueur->joueursParNom('');

        expect($result)->toBeArray()
            ->and($result)->not->toBeEmpty()
            ->and($result[0])->toBeInstanceOf(JoueurBaseSPID::class)
            ->and($result[0]->licence())->toBe('552494');
    });

    it('devrait retourner un tableau vide si aucun joueur trouvé par nom', function (): void {
        $result = $this->api->joueur->joueursParNom('999999');

        expect($result)->toBeArray()->and($result)->toBeEmpty();
    });

    it('devrait rechercher des joueurs par leur club (base SPID)', function (): void {
        $result = $this->api->joueur->joueursParClubSurBaseSPID('');

        expect($result)->toBeArray()
            ->and($result)->not->toBeEmpty()
            ->and($result[0])->toBeInstanceOf(JoueurBaseSPID::class)
            ->and($result[0]->licence())->toBe('167376');
    });

    it('devrait retourner un tableau vide si aucun joueur trouvé par club (base SPID)', function (): void {
        $result = $this->api->joueur->joueursParClubSurBaseSPID('999999');

        expect($result)->toBeArray()->and($result)->toBeEmpty();
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

    it('devrait retourner un tableau vide si aucun joueur trouvé par club', function (): void {
        $result = $this->api->joueur->joueursParClub('999999');

        expect($result)->toBeArray()->and($result)->toBeEmpty();
    });

    it('devrait rechercher des joueurs par leur club et leur type de licence', function (): void {
        $result = $this->api->joueur->joueursParClubEtType('', [TypeLicence::COMPETITION]);

        expect($result)->toBeArray()
            ->and($result)->not->toBeEmpty()
            ->and($result[0])->toBeInstanceOf(DetailJoueur::class)
            ->and($result[0]->licence())->toBe('167376')
            ->and($result[0]->typeLicence())->toBe(TypeLicence::COMPETITION);
    });

    it('devrait retourner un tableau vide si aucun joueur trouvé par club et type de licence', function (): void {
        $result = $this->api->joueur->joueursParClubEtType('999999', [TypeLicence::COMPETITION]);

        expect($result)->toBeArray()->and($result)->toBeEmpty();
    });

    it('devrait rechercher des joueurs par leur numéro de licence', function (): void {
        $result = $this->api->joueur->joueurParLicence('1');

        expect($result)
            ->toBeInstanceOf(DetailJoueur::class)
            ->and($result->licence())->toBe('1616528');
    });

    it('devrait retourner null si aucun joueur trouvé par numéro de licence', function (): void {
        $result = $this->api->joueur->joueurParLicence('999999');

        expect($result)->toBeNull();
    });
});

describe('[xml_joueur]', function (): void {
    it('devrait rechercher des joueurs par leur numéro de licence (base classement)', function (): void {
        $result = $this->api->joueur->joueurParLicenceSurBaseClassement('1');

        expect($result)
            ->toBeInstanceOf(DetailJoueurBaseClassement::class)
            ->and($result->licence())->toBe('1610533');
    });

    it('devrait retourner null si aucun joueur trouvé par numéro de licence (base classement)', function (): void {
        $result = $this->api->joueur->joueurParLicenceSurBaseClassement('999999');

        expect($result)->toBeNull();
    });
});

describe('[xml_licence]', function (): void {
    it('devrait rechercher des joueurs par leur numéro de licence (base SPID)', function (): void {
        $result = $this->api->joueur->joueurParLicenceSurBaseSPID('1');

        expect($result)
            ->toBeInstanceOf(DetailJoueurBaseSPID::class)
            ->and($result->licence())->toBe('1610533');
    });

    it('devrait retourner null si aucun joueur trouvé par numéro de licence (base SPID)', function (): void {
        $result = $this->api->joueur->joueurParLicenceSurBaseSPID('999999');

        expect($result)->toBeNull();
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

    it("devrait retourner un tableau vide si aucun joueur trouvé pour l'historique des parties (base classement)", function (): void {
        $result = $this->api->joueur->historiquePartiesBaseClassement('999999');

        expect($result)->toBeArray()->and($result)->toHaveCount(0);
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

    it("devrait retourner un tableau vide si aucun joueur trouvé pour l'historique des parties (base SPID)", function (): void {
        $result = $this->api->joueur->historiquePartiesBaseSPID('999999');

        expect($result)->toBeArray()->and($result)->toHaveCount(0);
    });

    it("devrait récupérer l'historique des parties d'un joueur", function (): void {
        $result = $this->api->joueur->historiqueParties('1');

        expect($result)->toBeArray()
            ->and($result)->not->toBeEmpty()
            ->and($result[0])->toBeInstanceOf(Partie::class)
            ->and($result[0]->partieId())->toBe(12434534);
    });

    it("devrait retourner un tableau vide si aucun joueur trouvé pour l'historique des parties", function (): void {
        $result = $this->api->joueur->historiqueParties('999999');

        expect($result)->toBeArray()->and($result)->toHaveCount(0);
    });

    it("devrait récupérer les parties validées d'un joueur", function (): void {
        $result = $this->api->joueur->partiesValidees('1');

        expect($result)->toBeArray()
            ->and($result)->toHaveCount(15)
            ->and($result[0])->toBeInstanceOf(Partie::class);
    });

    it("devrait retourner un tableau vide si aucun joueur trouvé pour récupérer les parties validées", function (): void {
        $result = $this->api->joueur->partiesValidees('999999');

        expect($result)->toBeArray()->and($result)->toHaveCount(0);
    });

    it("devrait récupérer les parties non-validées d'un joueur", function (): void {
        $result = $this->api->joueur->partiesNonValidees('1');

        expect($result)->toBeArray()
            ->and($result)->toHaveCount(16)
            ->and($result[0])->toBeInstanceOf(Partie::class);
    });

    it('devrait retourner un tableau vide si aucun joueur trouvé pour récupérer les parties non-validées', function (): void {
        $result = $this->api->joueur->partiesNonValidees('999999');

        expect($result)->toBeArray()->and($result)->toHaveCount(0);
    });

    it("devrait calculer les points virtuels des parties non-validées d'un joueur", function (): void {
        $result = $this->api->joueur->pointsVirtuels('1');

        expect($result)->toBe(-104.0);
    });

    it('devrait retourner null si aucun joueur trouvé pour calculer les points virtuels', function (): void {
        $result = $this->api->joueur->pointsVirtuels('999999');

        expect($result)->toBeNull();
    });

    it("devrait calculer les points virtuels des parties non-validées d'un joueur sur une période donnée", function (): void {
        $result = $this->api->joueur->pointsVirtuelsSurPeriode('1', '15/03/2026', '15/03/2026');

        expect($result)->toBe(-87.0);
    });

    it('devrait retourner null si aucun joueur trouvé pour calculer les points virtuels sur une période donnée', function (): void {
        $result = $this->api->joueur->pointsVirtuelsSurPeriode('999999', '15/03/2026', '15/03/2026');

        expect($result)->toBeNull();
    });
});

describe('[xml_histo_classement]', function (): void {
    it("devrait récupérer l'historique de classement d'un joueur", function (): void {
        $result = $this->api->joueur->historiqueClassementOfficiel('1');

        expect($result)->toBeArray()
            ->and($result[0])->toBeInstanceOf(HistoriqueClassement::class)
            ->and($result[0]->pointsOfficiels())->toBe(500.0);
    });

    it("devrait retourner un tableau vide si aucun joueur trouvé pour l'historique de classement", function (): void {
        $result = $this->api->joueur->historiqueClassementOfficiel('999999');

        expect($result)->toBeArray()->and($result)->toHaveCount(0);
    });
});
