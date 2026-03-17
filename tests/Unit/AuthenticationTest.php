<?php

declare(strict_types=1);

use FFTTApi\FFTTApi;
use FFTTApi\Tests\HttpClientMock;

beforeEach(function (): void {
    $this->api = FFTTApi::create('', '', '', new HttpClientMock);
});

it("devrait s'authentifier", function (): void {
    $result = $this->api->authentification->authentifier();

    expect($result)->toBeTrue();
});
