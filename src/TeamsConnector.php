<?php

namespace Sebbmyr\Teams;

/**
 * Teams connector
 */
class TeamsConnector
{
    private $webhookUrl;

    public function __construct($webhookUrl)
    {
        $this->webhookUrl = $webhookUrl;
    }

    /**
     * Sends card message as POST request
     *
     * @param  TeamsConnectorInterface $card
     * @param  int $timeout by default = 10
     * @param  int $connectTimeout by default = 3
     * @throws Exception
     */
    public function send(TeamsConnectorInterface $card, $timeout = 10, $connectTimeout = 3)
    {
        $json = json_encode($card->getMessage());

        $ch = curl_init($this->webhookUrl);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $connectTimeout);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($json)
        ]);

        $result = curl_exec($ch);

        if (curl_error($ch)) {
            throw new \Exception(curl_error($ch), curl_errno($ch));
        }
        if ($result !== "1") {
            throw new \Exception('Error response: ' . $result);
        }
    }
}
