<?php

namespace App\Service;

use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;

class MercureJwtProvider
{
    private string $jwt;

    public function __construct(string $secret, string $topic)
    {
        $config = Configuration::forSymmetricSigner(
            new Sha256(),
            InMemory::plainText($secret)
        );

        $token = $config->builder()
            ->withClaim('mercure', ['publish' => [$topic]])
            ->getToken($config->signer(), $config->signingKey());

        $this->jwt = $token->toString();
    }

    public function getJwt(): string
    {
        return $this->jwt;
    }
}
