<?php declare(strict_types=1);

namespace App\Service;

use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BillingService
{
    const BILLING_URL = 'https://ya.ru';

    private Client $guzzleHttpClient;

    public function __construct( Client $guzzleClient)
    {
        $this->guzzleHttpClient = $guzzleClient;
    }

    public function pay(): bool
    {
        $response = $this->guzzleHttpClient->request(Request::METHOD_GET, self::BILLING_URL);
        return $response->getStatusCode() === Response::HTTP_OK;
    }
}
