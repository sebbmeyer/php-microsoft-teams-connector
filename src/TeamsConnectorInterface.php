<?php

namespace Sebbmyr\Teams;

interface TeamsConnectorInterface
{
    public function setWebhookUrl($webhookUrl);

    public function send(CardInterface $card, $curlOptTimeout = 10, $curlOptConnectTimeout = 3);
}