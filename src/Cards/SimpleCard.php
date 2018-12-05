<?php

namespace Sebbmyr\Teams\Cards;

use Sebbmyr\Teams\AbstractCard as Card;

/**
 * Simple card for microsoft teams
 */
class SimpleCard extends Card
{

    public function getMessage()
    {
        return [
            "@context" => "http://schema.org/extensions",
            "@type" => "MessageCard",
            "themeColor" => !empty($this->data['themeColor']) ? $this->data['themeColor'] : "0072C6",
            "title" => $this->data['title'],
            "text" => $this->data['text']
        ];
    }
}
