<?php

namespace Sebbmyr\Teams\Cards\Adaptive;

use Sebbmyr\Teams\AbstractCard as Card;
use Sebbmyr\Teams\Cards\Adaptive\Contracts\FullWidth;

/**
 * Base adaptive card
 */
class BaseAdaptiveCard extends Card
{
    use FullWidth;
    
    public function getMessage()
    {
        $card = [
            "contentType" => "application/vnd.microsoft.card.adaptive",
            "contentUrl" => null,
            "content" => [
                "\$schema" => "http://adaptivecards.io/schemas/adaptive-card.json",
                "type" => "AdaptiveCard",
                "version" => "1.2",
            ],
        ];

        if ($this->fullWidth) {
            $card["content"]['msteams'] = [
                "width" => "Full",
            ];
        }

        $acceptedKeys = [
            "actions",
            "body",
            "selectAction",
            "fallbackText",
            "backgroundImage",
            "minHeight",
            "speak",
            "lang",
            "verticalContentAligment",
        ];
        foreach ($this->data as $key => $value) {
            if (!in_array($key, $acceptedKeys)) {
                continue;
            }
            
            $card["content"][$key] = $value;
        }

        $message = [
            "type" => "message",
            "attachments" => [$card],
        ];

        return $message;
    }
}
