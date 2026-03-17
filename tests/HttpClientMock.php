<?php

declare(strict_types=1);

namespace FFTTApi\Tests;

use FFTTApi\Core\AbstractHttpClient;
use FFTTApi\Core\HttpClientContract;
use FFTTApi\Enum\API;
use InvalidArgumentException;

final class HttpClientMock extends AbstractHttpClient implements HttpClientContract
{
    public function fetch(API $endpoint, array $requestParams): array
    {
        $mock = match (true) {
            $endpoint === API::XML_CHP_RENC => 'xml_chp_renc/default.xml',
            $endpoint === API::XML_CLUB_B && array_key_exists('dep', $requestParams) => 'xml_club_b/par_departement.xml',
            $endpoint === API::XML_CLUB_B && array_key_exists('ville', $requestParams) => 'xml_club_b/par_ville.xml',
            $endpoint === API::XML_CLUB_B && array_key_exists('code', $requestParams) => 'xml_club_b/par_code_postal.xml',
            $endpoint === API::XML_CLUB_B && array_key_exists('numero', $requestParams) => 'xml_club_b/par_numero.xml',
            $endpoint === API::XML_CLUB_DEP_2 => 'xml_club_dep2/default.xml',
            $endpoint === API::XML_CLUB_DETAIL => 'xml_club_detail/default.xml',
            $endpoint === API::XML_DIVISION && $requestParams['type'] === 'E' => 'xml_division/par_equipes.xml',
            $endpoint === API::XML_DIVISION && $requestParams['type'] === 'I' => 'xml_division/individuelle.xml',
            $endpoint === API::XML_EPREUVE && $requestParams['type'] === 'E' => 'xml_epreuve/par_equipes.xml',
            $endpoint === API::XML_EPREUVE && $requestParams['type'] === 'I' => 'xml_epreuve/individuelles.xml',
            $endpoint === API::XML_EQUIPE => 'xml_equipe/default.xml',
            $endpoint === API::XML_HISTO_CLASSEMENT => 'xml_histo_classement/default.xml',
            $endpoint === API::XML_INITIALISATION => 'xml_initialisation/valide.xml',
            $endpoint === API::XML_JOUEUR => 'xml_joueur/default.xml',
            $endpoint === API::XML_LICENCE => 'xml_licence/default.xml',
            $endpoint === API::XML_LICENCE_B && array_key_exists('club', $requestParams) => 'xml_licence_b/club.xml',
            $endpoint === API::XML_LICENCE_B && !array_key_exists('club', $requestParams) => 'xml_licence_b/joueur.xml',
            $endpoint === API::XML_LISTE_JOUEUR && array_key_exists('club', $requestParams) => 'xml_liste_joueur/par_club.xml',
            $endpoint === API::XML_LISTE_JOUEUR && array_key_exists('nom', $requestParams) && !array_key_exists('prenom', $requestParams) => 'xml_liste_joueur/par_nom.xml',
            $endpoint === API::XML_LISTE_JOUEUR && array_key_exists('nom', $requestParams) && array_key_exists('prenom', $requestParams) => 'xml_liste_joueur/par_nom_prenom.xml',
            $endpoint === API::XML_LISTE_JOUEUR_O && array_key_exists('nom', $requestParams) => 'xml_liste_joueur_o/par_nom.xml',
            $endpoint === API::XML_LISTE_JOUEUR_O && array_key_exists('nom', $requestParams) && array_key_exists('prenom', $requestParams) => 'xml_liste_joueur_o/par_nom_prenom.xml',
            $endpoint === API::XML_LISTE_JOUEUR_O && array_key_exists('licence', $requestParams) => 'xml_liste_joueur_o/par_licence.xml',
            $endpoint === API::XML_LISTE_JOUEUR_O && array_key_exists('club', $requestParams) && array_key_exists('valid', $requestParams) => 'xml_liste_joueur_o/par_club_valides.xml',
            $endpoint === API::XML_LISTE_JOUEUR_O && array_key_exists('club', $requestParams) => 'xml_liste_joueur_o/par_club.xml',
            $endpoint === API::XML_NEW_ACTU => 'xml_new_actu/default.xml',
            $endpoint === API::XML_ORGANISME && $requestParams['type'] === 'F' => 'xml_organisme/federation.xml',
            $endpoint === API::XML_ORGANISME && $requestParams['type'] === 'Z' => 'xml_organisme/zones.xml',
            $endpoint === API::XML_ORGANISME && $requestParams['type'] === 'L' => 'xml_organisme/ligues.xml',
            $endpoint === API::XML_ORGANISME && $requestParams['type'] === 'D' => 'xml_organisme/departements.xml',
            $endpoint === API::XML_PARTIE => 'xml_partie/default.xml',
            $endpoint === API::XML_PARTIE_MYSQL => 'xml_partie_mysql/default.xml',
            $endpoint === API::XML_RENCONTRE_EQU && str_contains((string)$requestParams['poule'], '|') => 'xml_rencontre_equ/multiple.xml',
            $endpoint === API::XML_RENCONTRE_EQU => 'xml_rencontre_equ/unique.xml',
            $endpoint === API::XML_RES_CLA => 'xml_res_cla/numerote.xml',
            $endpoint === API::XML_RESULT_EQU && $requestParams['action'] === 'poule' => 'xml_result_equ/poules.xml',
            $endpoint === API::XML_RESULT_EQU && $requestParams['action'] === 'classement' => 'xml_result_equ/classement.xml',
            $endpoint === API::XML_RESULT_EQU && $requestParams['action'] === 'initial' => 'xml_result_equ/composition.xml',
            $endpoint === API::XML_RESULT_EQU && $requestParams['action'] === '' => 'xml_result_equ/rencontres.xml',
            $endpoint === API::XML_RESULT_INDIV && $requestParams['action'] === 'poule' => 'xml_result_indiv/groupes.xml',
            $endpoint === API::XML_RESULT_INDIV && $requestParams['action'] === 'classement' => 'xml_result_indiv/classement.xml',
            $endpoint === API::XML_RESULT_INDIV && $requestParams['action'] === 'partie' => 'xml_result_indiv/parties.xml',
            default => throw new InvalidArgumentException('Endpoint API non supporté')
        };

        $mockContent = file_get_contents(__DIR__ . '/../../snapshots/snapshots/' . $mock);

        $content = $this->sanitizeResponse($mockContent);

        return $this->convertXmlToObject($content);
    }
}
