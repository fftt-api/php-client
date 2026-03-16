<?php

declare(strict_types=1);

namespace FFTTApi\Service;

use FFTTApi\Contract\JoueurContract;
use FFTTApi\Core\HttpClientContract;
use FFTTApi\Enum\API;
use FFTTApi\Model\Joueur\DetailJoueur;
use FFTTApi\Model\Joueur\DetailJoueurBaseClassement;
use FFTTApi\Model\Joueur\DetailJoueurBaseSPID;
use FFTTApi\Model\Joueur\HistoriqueClassement;
use FFTTApi\Model\Joueur\JoueurBaseClassement;
use FFTTApi\Model\Joueur\JoueurBaseSPID;
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
        $response = $this->httpClient->fetch(API::XML_LICENCE_B, ['club' => $numeroClub]);

        return array_map(DetailJoueur::fromArray(...), $response['licence'] ?? []);
    }

    /** @inheritdoc */
    public function joueursParClubEtType(string $numeroClub, array $typesLicence): array
    {
        $response = $this->httpClient->fetch(API::XML_LICENCE_B, ['club' => $numeroClub]);

        $joueurs = array_map(DetailJoueur::fromArray(...), $response['licence'] ?? []);

        return array_filter($joueurs, fn (DetailJoueur $joueur) => in_array($joueur->typeLicence(), $typesLicence, strict: true));
    }

    /** @inheritdoc */
    public function joueurParLicenceSurBaseClassement(string $licence): ?DetailJoueurBaseClassement
    {
        $response = $this->httpClient->fetch(API::XML_JOUEUR, ['licence' => $licence]);

        if ($response === []) {
            return null;
        }

        return DetailJoueurBaseClassement::fromArray($response['joueur']);
    }

    public function joueurParLicenceSurBaseSPID(string $licence): ?DetailJoueurBaseSPID
    {
        $response = $this->httpClient->fetch(API::XML_LICENCE, ['licence' => $licence]);

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
    public function pointsVirtuels(string $licence): float
    {
        $joueur = $this->joueurParLicence($licence);
        $parties = $this->partiesNonValidees($licence);

        return array_reduce(
            array: $parties,
            callback: function (float $total, Partie $partie) use ($joueur): float {
                if ($partie->forfait()) {
                    return $total;
                }

                $resultat = EstimationPoint::estimer(
                    classementJoueurA: $joueur->pointsOfficiels(),
                    classementJoueurB: $partie->pointsAdversaire(),
                    victoire: $partie->victoire(),
                    coefficient: $partie->coefficient(),
                );

                return $total + $resultat;
            },
            initial: 0,
        );
    }

    /** @inheritdoc */
    public function pointsVirtuelsSurPeriode(string $licence, string $debut, string $fin): float
    {
        $joueur = $this->joueurParLicence($licence);
        $dateDebut = DateTimeUtils::date($debut, format: 'd/m/Y');
        $dateFin = DateTimeUtils::date($fin, format: 'd/m/Y');

        return array_reduce(
            array: $this->partiesNonValidees($licence),
            callback: function (float $total, Partie $partie) use ($joueur, $dateDebut, $dateFin): float {
                $dateInRange = $partie->date()->isAfter($dateDebut) && $partie->date()->isBefore($dateFin);
                $exactDate = $partie->date()->isSameDay($dateDebut);

                if (($exactDate || $dateInRange) && !$partie->forfait()) {
                    $resultat = EstimationPoint::estimer(
                        classementJoueurA: $joueur->pointsOfficiels(),
                        classementJoueurB: $partie->pointsAdversaire(),
                        victoire: $partie->victoire(),
                        coefficient: $partie->coefficient(),
                    );

                    return $total + $resultat;
                }

                return $total;
            },
            initial: 0,
        );
    }
}
