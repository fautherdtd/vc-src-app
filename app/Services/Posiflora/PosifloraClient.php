<?php

namespace App\Services\Posiflora;

use Exception;

class PosifloraClient
{
    private string $baseUrl = 'https://valscvetovv.posiflora.com/api/v1/';
    private ?string $accessToken = null;

    /**
     * @throws Exception
     */
    public function sessionStart(): void
    {
        $url = $this->baseUrl . 'sessions';
        $payload = [
            'data' => [
                'type' => 'sessions',
                'attributes' => [
                    'username' => 'Djoni',
                    'password' => '3998',
                ],
            ],
        ];

        $response = $this->makeRequest('POST', $url, $payload, false);

        if (isset($response['data']['attributes']['accessToken'])) {
            $this->accessToken = $response['data']['attributes']['accessToken'];
        } else {
            throw new Exception('Access token not found in response.');
        }
    }

    /**
     * @throws Exception
     */
    private function makeRequest(string $method, string $url, array $payload = [], bool $auth = true): array
    {
        $headers = [
            'Content-Type: application/json',
        ];

        if ($auth && $this->accessToken) {
            $headers[] = 'Authorization: Bearer ' . $this->accessToken;
        }

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            throw new Exception('Curl error: ' . curl_error($ch));
        }

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $decoded = json_decode($result, true);

        if ($httpCode >= 400) {
            throw new Exception('API Error ' . $method . ': ' . ($decoded['errors'][0]['detail'] ?? 'Unknown error'));
        }

        return $decoded;
    }

    public function patchResource(string $endpoint, array $payload = []): array
    {
        $url = $this->baseUrl . ltrim($endpoint, '/');

        $headers = [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->accessToken,
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            throw new \Exception('Curl error: ' . curl_error($ch));
        }

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $decoded = json_decode($result, true);

        if ($httpCode >= 400) {
            throw new \Exception('API Error: ' . ($decoded['errors'][0]['detail'] ?? 'Unknown error'));
        }

        return $decoded;
    }

    public function getAccessToken(): ?string
    {
        return $this->accessToken;
    }

    /**
     * @throws Exception
     */
    public function getSomeProtectedResource(string $endpoint): array
    {
        $url = $this->baseUrl . ltrim($endpoint, '/');
        return $this->makeRequest('GET', $url);
    }

}
