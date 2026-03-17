<?php

declare(strict_types=1);

use FFTTApi\FFTTApi;
use FFTTApi\Tests\HttpClientMock;

it("devrait s'authentifier avec les bons identifiants", function (): void {
    $api = FFTTApi::create(appId: '', appKey: '', serial: '1234', httpClient: HttpClientMock::class);
    $result = $api->authentification->authentifier();

    expect($result)->toBeTrue();
});

it("devrait lever une exception avec les mauvais identifiants", function (): void {
    $api = FFTTApi::create(appId: '', appKey: '', serial: '6789', httpClient: HttpClientMock::class);

    expect(fn () => $api->authentification->authentifier())
        ->toThrow(\FFTTApi\Exception\HttpException::class, 'Compte incorrect');
});
