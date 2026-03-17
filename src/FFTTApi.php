<?php

declare(strict_types=1);

namespace FFTTApi;

use FFTTApi\Core\HttpClient;
use FFTTApi\Core\HttpClientContract;
use FFTTApi\Service\ActualitesService;
use FFTTApi\Service\AuthentificationService;
use FFTTApi\Service\ClubService;
use FFTTApi\Service\EpreuveIndividuelleService;
use FFTTApi\Service\EpreuveParEquipeService;
use FFTTApi\Service\EpreuveService;
use FFTTApi\Service\JoueurService;
use FFTTApi\Service\OrganismeService;

final readonly class FFTTApi
{
    public ActualitesService $actualites;

    public AuthentificationService $authentification;

    public ClubService $club;

    public EpreuveIndividuelleService $epreuveIndividuelle;

    public EpreuveParEquipeService $epreuveParEquipe;

    public EpreuveService $epreuve;

    public JoueurService $joueur;

    public OrganismeService $organisme;

    private function __construct(private HttpClientContract $httpClient)
    {
        $this->actualites = new ActualitesService($this->httpClient);
        $this->authentification = new AuthentificationService($this->httpClient);
        $this->club = new ClubService($this->httpClient);
        $this->epreuveIndividuelle = new EpreuveIndividuelleService($this->httpClient);
        $this->epreuveParEquipe = new EpreuveParEquipeService($this->httpClient);
        $this->epreuve = new EpreuveService($this->httpClient);
        $this->joueur = new JoueurService($this->httpClient);
        $this->organisme = new OrganismeService($this->httpClient);
    }

    /**
     * Initialise la librairie avec les identifiants fournis par la FFTT.
     *
     * @param string $appId Identifiant unique fourni par la FFTT.
     * @param string $appKey Mot de passe unique fourni par la FFTT.
     * @param string $serial Chaîne de caractères identifiant l'utilisateur de façon permanente, doit respecter le format suivant : [A-Za-z0-9]{15}.
     * @param class-string<HttpClientContract>|null $httpClient Classe du client HTTP à utiliser.
     */
    public static function create(string $appId, string $appKey, string $serial, ?string $httpClient = null): self
    {
        if (!is_subclass_of($httpClient, HttpClientContract::class)) {
            $httpClient = new HttpClient($appId, $appKey, $serial);
        } else {
            $httpClient = new $httpClient($appId, $appKey, $serial);
        }

        return new self($httpClient);
    }
}
