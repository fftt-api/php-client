<?php

declare(strict_types=1);

namespace FFTTApi\Service;

use FFTTApi\Contract\ClubContract;
use FFTTApi\Core\HttpClientContract;
use FFTTApi\Enum\API;
use FFTTApi\Enum\Charset;
use FFTTApi\Enum\TypeEquipe;
use FFTTApi\Model\Club\Club;
use FFTTApi\Model\Club\DetailClub;
use FFTTApi\Model\Club\Equipe;

final readonly class ClubService implements ClubContract
{
    public function __construct(private HttpClientContract $httpClient)
    {
    }

    /** @inheritdoc */
    public function clubsParDepartement(string $departement): array
    {
        $response = $this->httpClient->fetch(API::XML_CLUB_DEP_2, ['dep' => $departement]);

        return array_map(
            Club::fromArray(...),
            $response['club'] ?? []
        );
    }

    /** @inheritdoc */
    public function clubsParCodePostal(string $codePostal): array
    {
        $response = $this->httpClient->fetch(API::XML_CLUB_B, ['code' => $codePostal]);

        return array_map(
            Club::fromArray(...),
            $response['club'] ?? []
        );
    }

    /** @inheritdoc */
    public function clubsParVille(string $ville): array
    {
        $response = $this->httpClient->fetch(API::XML_CLUB_B, ['ville' => $ville]);

        return array_map(
            Club::fromArray(...),
            $response['club'] ?? []
        );
    }

    /** @inheritdoc */
    public function clubsParNom(string $nom): array
    {
        $response = $this->httpClient->fetch(API::XML_CLUB_B, ['ville' => $nom]);

        return array_map(
            Club::fromArray(...),
            $response['club'] ?? []
        );
    }

    /** @inheritdoc */
    public function detailClub(string $code, ?string $idEquipe = null): ?DetailClub
    {
        $params = ['club' => $code];

        if ($idEquipe !== null) {
            $params['idequipe'] = $idEquipe;
        }

        $response = $this->httpClient->fetch(API::XML_CLUB_DETAIL, $params);

        if ($response === []) {
            return null;
        }

        return DetailClub::fromArray($response['club']);
    }

    /** @inheritdoc */
    public function equipesClub(string $code, TypeEquipe $typeEquipe): array
    {
        $response = $this->httpClient->fetch(API::XML_EQUIPE, [
            'numclu' => $code,
            'type' => $typeEquipe->value,
        ], Charset::ISO_8859_1);

        return array_map(
            Equipe::fromArray(...),
            $response['equipe'] ?? []
        );
    }
}
