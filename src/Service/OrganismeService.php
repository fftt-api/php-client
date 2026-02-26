<?php

declare(strict_types=1);

namespace FFTTApi\Service;

use FFTTApi\Contract\OrganismeContract;
use FFTTApi\Core\HttpClientContract;
use FFTTApi\Enum\API;
use FFTTApi\Enum\TypeOrganisme;
use FFTTApi\Model\Organisme\Organisme;

final class OrganismeService implements OrganismeContract
{
    /**
     * @var array<array-key, Organisme> Store de l'ensemble des organismes,
     * nécessaire puisque l'API ne propose aucun endpoint pour en récupérer
     * une facilement par son identifiant.
     */
    private array $organismes = [];

    public function __construct(private readonly HttpClientContract $httpClient)
    {
        $this->remplirOrganismes();
    }

    /** @inheritdoc */
    public function organismesParType(TypeOrganisme $orgType): array
    {
        return array_values(array_filter(
            $this->organismes,
            fn (Organisme $org): bool => $org->type() === $orgType
        ));
    }

    /** @inheritdoc */
    public function organisme(string $code): ?Organisme
    {
        return array_find($this->organismes, fn (Organisme $org): bool => $org->code() === $code);
    }

    /** @inheritdoc */
    public function organismesEnfants(string $code): array
    {
        $parentId = $this->organisme($code)?->id();

        if ($parentId === null) {
            return [];
        }

        return array_values(array_filter(
            $this->organismes,
            fn (Organisme $org): bool => $org->idOrganismeParent() === $parentId
        ));
    }

    private function remplirOrganismes(): void
    {
        if ($this->organismes !== []) {
            return;
        }

        $orgTypes = TypeOrganisme::cases();

        $fetch = function (TypeOrganisme $orgType): array {
            $response = $this->httpClient->fetch(API::XML_ORGANISME, ['type' => $orgType->value]);

            if (array_key_exists('id', $response['organisme'])) {
                return [Organisme::fromArray($response['organisme'])];
            }

            return array_map(Organisme::fromArray(...), $response['organisme'] ?? []);
        };

        foreach ($orgTypes as $type) {
            $this->organismes = array_merge($this->organismes, $fetch($type));
        }
    }
}
