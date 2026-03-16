<?php

declare(strict_types=1);

use FFTTApi\Core\HttpClientMock;
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

beforeEach(function (): void {
    $this->api = FFTTApi::create('', '', '', new HttpClientMock);
});

it("devrait rechercher des joueurs par leur nom (base classement)", function (): void {
    $result = $this->api->joueur->joueursParNomSurBaseClassement('');

    expect($result)->toBeArray()
        ->and($result)->not->toBeEmpty()
        ->and($result[0])->toBeInstanceOf(JoueurBaseClassement::class)
        ->and($result[0]->licence())->toBe('552494');
});

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

it('devrait rechercher des joueurs par leur club (base classement)', function (): void {
    $result = $this->api->joueur->joueursParClubSurBaseClassement('');

    expect($result)->toBeArray()
        ->and($result)->not->toBeEmpty()
        ->and($result[0])->toBeInstanceOf(JoueurBaseClassement::class)
        ->and($result[0]->licence())->toBe('167374');
});

it('devrait rechercher des joueurs par leur club (base SPID)', function (): void {
    $result = $this->api->joueur->joueursParClubSurBaseSPID('');

    expect($result)->toBeArray()
        ->and($result)->not->toBeEmpty()
        ->and($result[0])->toBeInstanceOf(JoueurBaseSPID::class)
        ->and($result[0]->licence())->toBe('167376');
});

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

it('devrait rechercher des joueurs par leur numéro de licence (base classement)', function (): void {
    $result = $this->api->joueur->joueurParLicenceSurBaseClassement('');

    expect($result)
        ->toBeInstanceOf(DetailJoueurBaseClassement::class)
        ->and($result->licence())->toBe('1610533');
});

it('devrait rechercher des joueurs par leur numéro de licence (base SPID)', function (): void {
    $result = $this->api->joueur->joueurParLicenceSurBaseSPID('');

    expect($result)
        ->toBeInstanceOf(DetailJoueurBaseSPID::class)
        ->and($result->licence())->toBe('1610533');
});

it('devrait rechercher des joueurs par leur numéro de licence', function (): void {
    $result = $this->api->joueur->joueurParLicence('');

    expect($result)
        ->toBeInstanceOf(DetailJoueur::class)
        ->and($result->licence())->toBe('1616528');
});

it("devrait récupérer l'historique des parties d'un joueur (base classement)", function (): void {
    $result = $this->api->joueur->historiquePartiesBaseClassement('');

    expect($result)->toBeArray()
        ->and($result)->not->toBeEmpty()
        ->and($result[0])->toBeInstanceOf(PartieBaseClassement::class)
        ->and($result[0]->licence())->toBe('1616528');
});

it("devrait récupérer l'historique des parties d'un joueur (base SPID)", function (): void {
    $result = $this->api->joueur->historiquePartiesBaseSPID('');

    expect($result)->toBeArray()
        ->and($result)->not->toBeEmpty()
        ->and($result[0])->toBeInstanceOf(PartieBaseSPID::class)
        ->and($result[0]->partieId())->toBe(11614713);
});

it("devrait récupérer l'historique des parties d'un joueur", function (): void {
    $result = $this->api->joueur->historiqueParties('');

    expect($result)->toBeArray()
        ->and($result)->not->toBeEmpty()
        ->and($result[0])->toBeInstanceOf(Partie::class)
        ->and($result[0]->partieId())->toBe(11614713);
});

it("devrait récupérer les parties validées d'un joueur", function (): void {
    $result = $this->api->joueur->partiesValidees('');

    expect($result)->toBeArray()
        ->and($result)->toHaveCount(32)
        ->and($result[0])->toBeInstanceOf(Partie::class);
});

it("devrait récupérer les parties non-validées d'un joueur", function (): void {
    $result = $this->api->joueur->partiesNonValidees('');

    expect($result)->toBeArray()
        ->and($result)->toHaveCount(8)
        ->and($result[0])->toBeInstanceOf(Partie::class);
});

it("devrait calculer les points virtuels des parties non-validées d'un joueur", function (): void {
    $result = $this->api->joueur->pointsVirtuels('');

    expect($result)->toBe(28.75);
});

it("devrait calculer les points virtuels des parties non-validées d'un joueur sur une période donnée", function (): void {
    $result = $this->api->joueur->pointsVirtuelsSurPeriode('', '18/12/2025', '20/12/2025');

    expect($result)->toBe(11.0);
});

it("devrait récupérer l'historique de classement d'un joueur", function (): void {
    $result = $this->api->joueur->historiqueClassementOfficiel('');

    expect($result)->toBeArray()
        ->and($result[0])->toBeInstanceOf(HistoriqueClassement::class)
        ->and($result[0]->pointsOfficiels())->toBe(500.0);
});
