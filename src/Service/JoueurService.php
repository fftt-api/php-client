<?php

declare(strict_types=1);

namespace FFTTApi\Service;

use FFTTApi\Contract\JoueurContract;
use FFTTApi\Core\HttpClientContract;
use FFTTApi\Enum\API;
use FFTTApi\Exception\HttpException;
use FFTTApi\Model\Joueur\DetailJoueur;
use FFTTApi\Model\Joueur\DetailJoueurBaseClassement;
use FFTTApi\Model\Joueur\DetailJoueurBaseSPID;
use FFTTApi\Model\Joueur\HistoriqueClassement;
use FFTTApi\Model\Joueur\JoueurBaseClassement;
use FFTTApi\Model\Joueur\JoueurBaseSPID;
use FFTTApi\Model\Joueur\PointsVirtuels;
use FFTTApi\Model\Partie\Partie;
use FFTTApi\Model\Partie\PartieBaseClassement;
use FFTTApi\Model\Partie\PartieBaseSPID;
use FFTTApi\Util\DateTimeUtils;
use FFTTApi\Util\EstimationPoint;

final readonly class JoueurService implements JoueurContract
{
    public function __construct(private HttpClientContract $httpClient)
    {
    }

    /** @inheritdoc */
    public function joueursParNomSurBaseClassement(string $nom, ?string $prenom = null): array
    {
        $params = [];
        $params['nom'] = $nom;

        if ($prenom) {
            $params['prenom'] = $prenom;
        }

        $response = $this->httpClient->fetch(API::XML_LISTE_JOUEUR, $params);

        return array_map(JoueurBaseClassement::fromArray(...), $response['joueur'] ?? []);
    }

    /** @inheritdoc */
    public function joueursParNomSurBaseSPID(string $nom, ?string $prenom = null, bool $valide = false): array
    {
        $params = [];
        $params['nom'] = $nom;

        if ($prenom) {
            $params['prenom'] = $prenom;
        }

        if ($valide) {
            $params['valid'] = 1;
        }

        $response = $this->httpClient->fetch(API::XML_LISTE_JOUEUR_O, $params);

        return array_map(JoueurBaseSPID::fromArray(...), $response['joueur'] ?? []);
    }

    /** @inheritdoc */
    public function joueursParNom(string $nom, ?string $prenom = null, bool $valide = false): array
    {
        return $this->joueursParNomSurBaseSPID($nom, $prenom, $valide);
    }

    /** @inheritdoc */
    public function joueursParClubSurBaseClassement(string $numeroClub): array
    {
        $response = $this->httpClient->fetch(API::XML_LISTE_JOUEUR, ['club' => $numeroClub]);

        return array_map(JoueurBaseClassement::fromArray(...), $response['joueur'] ?? []);
    }

    /** @inheritdoc */
    public function joueursParClubSurBaseSPID(string $numeroClub, bool $valide = false): array
    {
        $params = [];
        $params['club'] = $numeroClub;

        if ($valide) {
            $params['valid'] = 1;
        }

        $response = $this->httpClient->fetch(API::XML_LISTE_JOUEUR_O, $params);

        return array_map(JoueurBaseSPID::fromArray(...), $response['joueur'] ?? []);
    }

    /** @inheritdoc */
    public function joueursParClub(string $numeroClub): array
    {
        try {
            $response = $this->httpClient->fetch(API::XML_LICENCE_B, ['club' => $numeroClub]);

            return array_map(DetailJoueur::fromArray(...), $response['licence'] ?? []);
        } catch (HttpException) {
            return [];
        }
    }

    /** @inheritdoc */
    public function joueursParClubEtType(string $numeroClub, array $typesLicence): array
    {
        try {
            $response = $this->httpClient->fetch(API::XML_LICENCE_B, ['club' => $numeroClub]);

            $joueurs = array_map(DetailJoueur::fromArray(...), $response['licence'] ?? []);

            return array_filter($joueurs, fn (DetailJoueur $joueur) => in_array($joueur->typeLicence(), $typesLicence, strict: true));
        } catch (HttpException) {
            return [];
        }
    }

    /** @inheritdoc */
    public function joueurParLicenceSurBaseClassement(string $licence): ?DetailJoueurBaseClassement
    {
        $response = $this->httpClient->fetch(API::XML_JOUEUR, ['numlic' => $licence]);

        if ($response === []) {
            return null;
        }

        return DetailJoueurBaseClassement::fromArray($response['joueur']);
    }

    public function joueurParLicenceSurBaseSPID(string $licence): ?DetailJoueurBaseSPID
    {
        $response = $this->httpClient->fetch(API::XML_LICENCE, ['numlic' => $licence]);

        if ($response === []) {
            return null;
        }

        return DetailJoueurBaseSPID::fromArray($response['licence']);
    }

    public function joueurParLicence(string $licence): ?DetailJoueur
    {
        $response = $this->httpClient->fetch(API::XML_LICENCE_B, ['licence' => $licence]);

        if ($response === []) {
            return null;
        }

        return DetailJoueur::fromArray($response['licence']);
    }

    /** @inheritdoc */
    public function historiquePartiesBaseClassement(string $licence): array
    {
        $response = $this->httpClient->fetch(API::XML_PARTIE_MYSQL, ['licence' => $licence]);

        if (empty($response)) {
            return [];
        }

        return array_map(PartieBaseClassement::fromArray(...), $response['partie'] ?? []);
    }

    /** @inheritdoc */
    public function historiquePartiesBaseSPID(string $licence): array
    {
        $response = $this->httpClient->fetch(API::XML_PARTIE, ['numlic' => $licence]);

        return array_map(PartieBaseSPID::fromArray(...), $response['partie'] ?? []);
    }

    /** @inheritdoc */
    public function historiqueParties(string $licence): array
    {
        $classement = $this->historiquePartiesBaseClassement($licence);
        $spid = $this->historiquePartiesBaseSPID($licence);
        $parties = [];

        foreach ($spid as $partieSPID) {
            $partieClassement = array_find($classement, fn (PartieBaseClassement $partie): bool => $partie->partieId() === $partieSPID->partieId());
            $parties[] = Partie::fromModels($partieSPID, $partieClassement);
        }

        return $parties;
    }

    /** @inheritdoc */
    public function historiqueClassementOfficiel(string $licence): array
    {
        $response = $this->httpClient->fetch(API::XML_HISTO_CLASSEMENT, ['licence' => $licence]);

        return array_map(HistoriqueClassement::fromArray(...), $response['histo'] ?? []);
    }

    /** @inheritdoc */
    public function partiesValidees(string $licence): array
    {
        return array_values(array_filter($this->historiqueParties($licence), fn (Partie $partie): bool => $partie->valide()));
    }

    /** @inheritdoc */
    public function partiesNonValidees(string $licence): array
    {
        return array_values(array_filter($this->historiqueParties($licence), fn (Partie $partie): bool => !$partie->valide()));
    }

    /** @inheritdoc */
    public function pointsVirtuels(string $licence): ?PointsVirtuels
    {
        $joueur = $this->joueurParLicence($licence);

        if ($joueur === null) {
            return null;
        }

        $parties = $this->partiesNonValidees($licence);

        $pointsVirtuels = new PointsVirtuels();

        foreach ($parties as $partie) {
            if ($partie->forfait()) {
                $pointsVirtuels->forfait();
                continue;
            }

            $estimation = EstimationPoint::estimer(
                classementJoueurA: $joueur->pointsOfficiels(),
                classementJoueurB: $partie->pointsAdversaire(),
                victoire: $partie->victoire(),
                coefficient: $partie->coefficient(),
            );

            if ($partie->victoire()) {
                $pointsVirtuels->victoire($estimation);
            } else {
                $pointsVirtuels->defaite($estimation);
            }
        }

        return $pointsVirtuels;
    }

    /** @inheritdoc */
    public function pointsVirtuelsSurPeriode(string $licence, string $debut, string $fin): ?PointsVirtuels
    {
        $joueur = $this->joueurParLicence($licence);

        if ($joueur === null) {
            return null;
        }

        $dateDebut = DateTimeUtils::date($debut, format: 'd/m/Y');
        $dateFin = DateTimeUtils::date($fin, format: 'd/m/Y');

        $parties = $this->partiesNonValidees($licence);

        $pointsVirtuels = new PointsVirtuels();

        foreach ($parties as $partie) {
            $dateInRange = $partie->date()->isAfter($dateDebut) && $partie->date()->isBefore($dateFin);
            $exactDate = $partie->date()->isSameDay($dateDebut);

            if (($exactDate || $dateInRange)) {
                if ($partie->forfait()) {
                    $pointsVirtuels->forfait();
                    continue;
                }

                $estimation = EstimationPoint::estimer(
                    classementJoueurA: $joueur->pointsOfficiels(),
                    classementJoueurB: $partie->pointsAdversaire(),
                    victoire: $partie->victoire(),
                    coefficient: $partie->coefficient(),
                );

                if ($partie->victoire()) {
                    $pointsVirtuels->victoire($estimation);
                } else {
                    $pointsVirtuels->defaite($estimation);
                }
            }
        }

        return $pointsVirtuels;
    }
}
