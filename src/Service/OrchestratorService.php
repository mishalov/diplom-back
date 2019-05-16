<?php
use GuzzleHttp\Exception\ConnectException;

namespace App\Service;

class OrchestratorService
{
    private function sendRequest($method, $endpoint)
    {
        $client = new \GuzzleHttp\Client(['http_errors' => false]);
        try {
            return $client->get("localhost:1488/$endpoint")->getBody();
        } catch (ConnectException $e) {
            var_dump($e);
        }
    }

    public function ping()
    {
        try {
            return $this->sendRequest("GET", "ping");
        } catch (\Guzzle\Http\Exception\ConnectException $e) {
            return false;
        }

    }
}