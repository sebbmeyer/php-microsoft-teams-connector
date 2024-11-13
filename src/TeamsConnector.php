<?php

namespace Sebbmyr\Teams;

/**
 * Teams connector
 */
class TeamsConnector implements TeamsConnectorInterface
{
    private $webhookUrl;

    public function __construct($webhookUrl = '')
    {
        $this->webhookUrl = $webhookUrl;
    }

    /**
     * @param string $webhookUrl
     * @return mixed
     */
    public function setWebhookUrl($webhookUrl)
    {
        $this->webhookUrl = $webhookUrl;

        return $this;
    }

    /**
     * Sends card message as POST request
     *
     * @param CardInterface $card
     * @param int $curlOptTimeout by default = 10
     * @param int $curlOptConnectTimeout by default = 3
     * @throws Exception
     */
    public function send(CardInterface $card, $curlOptTimeout = 10, $curlOptConnectTimeout = 3)
    {
        if ($this->webhookUrl === '') {
            throw new \Exception('No webhook url has been set');
        }

        $json = json_encode($card->getMessage());

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $this->webhookUrl,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $json,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => $curlOptTimeout,
            CURLOPT_CONNECTTIMEOUT => $curlOptConnectTimeout,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Content-Length: ' . strlen($json),
            ]
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
