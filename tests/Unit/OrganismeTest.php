<?php

declare(strict_types=1);

use FFTTApi\Core\HttpClientMock;
use FFTTApi\Enum\TypeOrganisme;
use FFTTApi\FFTTApi;
use FFTTApi\Model\Organisme\Organisme;

beforeEach(function (): void {
    $this->api = FFTTApi::create('', '', '', new HttpClientMock);
});

it("devrait récupérer les organismes d'un type particulier", function (): void {
    $result = $this->api->organisme->organismesParType(TypeOrganisme::ZONE);

    expect($result)->toBeArray()
        ->and($result)->toHaveCount(7)
        ->and($result[0])->toBeInstanceOf(Organisme::class)
        ->and($result[0]->code())->toBe('Z01');
});

it("devrait récupérer un organisme par son code", function (): void {
    $result = $this->api->organisme->organisme('D16');

    expect($result)
        ->toBeInstanceOf(Organisme::class)
        ->and($result->id())->toBe(131);
});

it("devrait récupérer les enfants d'un organisme", function (): void {
    $result = $this->api->organisme->organismesEnfants('FEDE');

    expect($result)->toBeArray()
        ->and($result)->toHaveCount(7)
        ->and($result[0])->toBeInstanceOf(Organisme::class)
        ->and($result[0]->code())->toBe('Z01');
});
