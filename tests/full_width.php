<?php

use Dotenv\Dotenv;
use Sebbmyr\Teams\Cards\Adaptive\BaseAdaptiveCard;
use Sebbmyr\Teams\TeamsConnector;

require_once(__DIR__.'/../vendor/autoload.php');

$dotenv = Dotenv::create(__DIR__.'/..');
$dotenv->load();

$titleItem = [
    "type" => "TextBlock",
    "text" => "AdaptiveCards test - Basic",
    "weight" => "bolder",
];
// create basic cards
$data = [
    "body" => [
        $titleItem,
        [
            "type" => "TextBlock",
            "text" => "Card displayed with auto width",
            "wrap" => true,

        ],
    ],
];
$dataFullWidth = [
    "body" => [
        $titleItem,
        [
            "type" => "TextBlock",
            "text" => "Card displayed with full width",
            "wrap" => true,

        ],
    ],
];


$baseAdaptiveCardAuto = (new BaseAdaptiveCard($data))->setFullWidth(false);
$baseAdaptiveCardFullWidth = (new BaseAdaptiveCard($dataFullWidth))->setFullWidth(true);
// create custom cards
$textBlockA = new  \Sebbmyr\Teams\Cards\Adaptive\Elements\TextBlock("AdaptiveCards test - Custom");
$textBlockA->setColor( \Sebbmyr\Teams\Cards\Adaptive\Styles::COLORS_WARNING)
    ->setSize( \Sebbmyr\Teams\Cards\Adaptive\Styles::FONT_SIZE_LARGE)
;
$textBlockB = new  \Sebbmyr\Teams\Cards\Adaptive\Elements\TextBlock("Card displayed with auto width");
$textBlockB->setIsSubtle(true);
$textBlockC = new  \Sebbmyr\Teams\Cards\Adaptive\Elements\TextBlock("Card displayed with full width");
$textBlockC->setIsSubtle(true);


$customCardAuto = (new \Sebbmyr\Teams\Cards\Adaptive\CustomAdaptiveCard())->setFullWidth(false);
$customCardAuto->addElement($textBlockA)
    ->addElement($textBlockB);
$customCardFullWidth = (new \Sebbmyr\Teams\Cards\Adaptive\CustomAdaptiveCard())->setFullWidth(true);
$customCardFullWidth->addElement($textBlockA)
    ->addElement($textBlockC);

// create connector instance
$connector = new TeamsConnector($_ENV['INCOMING_WEBHOOK']);
// send basic cards via connector
$connector->send($baseAdaptiveCardAuto);
$connector->send($baseAdaptiveCardFullWidth);
// send custom cards via connector
$connector->send($customCardAuto);
$connector->send($customCardFullWidth);