## PHP Microsoft Teams Connector

A PHP package to send notifications to Microsoft Teams by using "Incoming Webhook". The aim of this package is to create your own cards and simply send notifications to your desired channel. At the moment this package supports the following formats: MessageCard, AdaptiveCard and HeroCard.

## Package Installation - Composer

You can install the package via composer:

```bash
composer require sebbmeyer/php-microsoft-teams-connector
```

## Usage

When you want to send a simple notification to you channel, you can easily create a SimpleCard and send it via the TeamConnector

```php
<?php

require __DIR__ . '/vendor/autoload.php';
// create connector instance
$connector = new \Sebbmyr\Teams\TeamsConnector(<INCOMING_WEBHOOK_URL>);
// create card
$card  = new \Sebbmyr\Teams\Cards\SimpleCard(['title' => 'Simple card title', 'text' => 'Simple card text']);
// send card via connector
$connector->send($card);
```

### Send options

If you run into a timeout issue while sending a card to the Microsoft server, you can override the curl options for _timeout_ and _connectTimeout_ by passing your own values to the send method.

**send(TeamsConnectorInterface $card, $timeout = 10, $connectTimeout = 3)**

Name | Type | Required | Description
--- | --- | --- | ---
card | TeamsConnectorInterface | yes | Card object that implements the interface
timeout | int | no | (Default: 10) CURLOPT_TIMEOUT is maximum timeout in seconds. This value should include the connectTimeout value.
connectTimeout | int | no | (Default: 3) CURLOPT_CONNECTTIMEOUT is the maximum amount of time in seconds that is allowed to make the connection to the server

### MessageCard

To send a MessageCard you can use the provided **CustomCard** class and add a color, facts, images, an activity, actions or a summary to it.

```php
// create a custom card
$card  = new \Sebbmyr\Teams\Cards\CustomCard('Package update', 'A custom card class was added to the package.');
// add information
$card->setColor('01BC36')
    ->addFactsText('Supported PHP versions',['<= 5.4.0','7.x'])
    ->addFactsText('Unsupported PHP versions',['Before Version 5.4'])
    ->addAction('Visit Github repository','https://github.com/sebbmeyer/php-microsoft-teams-connector')
    ->addFacts('Facts Section',['Fact Name 1' => 'Fact Value 1','Fact Name 2' => 'Fact Value 2']);
```

Or you can create your own cards for every purpose you need, just extend the **AbstractCard** class and implement the `getMessage()` function. This package provides two predefined MessageCards that can use `SimpleCard` and `CustomCard`. For more information on these two cards, you can learn about it [here](docs/messageCards.md)

### AdaptiveCard

You can use almost every element you can find [here](https://adaptivecards.io/explorer/) except **Action.Submit** and as a consequence **Input** elements are useless at the moment. Currently it can be used in two ways:

1) Passing data as an array, you can design it how you want to. The data array can contain the following keys at the top level `body`, `actions`, `selectAction`, `fallbackText`, `backgroundImage`, `minHeight`, `speak`, `lang` and `verticalContentAlignment`. The properties `type`, `version` and `$schema` are set by the BaseAdaptiveCard.

```php
// create connector instance
$connector = new \Sebbmyr\Teams\TeamsConnector(<INCOMING_WEBHOOK_URL>);
// create data
$data = [
    "body" => [
        [
            "type" =>  "AdaptiveCards",
            "text" =>  "Adaptive card test. For Samples and Templates, see https://adaptivecards.io/samples](https://adaptivecards.io/samples)",
        ],
    ],
];
// create card
$card  = new \Sebbmyr\Teams\Cards\Adaptive\BaseAdaptiveCard($data);
// send card via connector
$connector->send($card);
```

2) Using the CustomAdaptiveCard which currently only handles TextBlock and Image elements, and Action.OpenUrl. The CustomAdaptiveCard is still in development and I will add the missing card elements, containers and actions soon.

```php
// create connector instance
$connector = new \Sebbmyr\Teams\TeamsConnector(<INCOMING_WEBHOOK_URL>);
// create data
$textBlockA = new  \Sebbmyr\Teams\Cards\Adaptive\Elements\TextBlock("Adaptive card");
$textBlockA->setColor( \Sebbmyr\Teams\Cards\Adaptive\Styles::COLORS_WARNING)
    ->setSize( \Sebbmyr\Teams\Cards\Adaptive\Styles::FONT_SIZE_LARGE)
;
$textBlockB = new  \Sebbmyr\Teams\Cards\Adaptive\Elements\TextBlock("Supported by composer package sebbmeyer/php-microsoft-teams-connector");
$textBlockB->setIsSubtle(true);
$image = new  \Sebbmyr\Teams\Cards\Adaptive\Elements\Image("https://adaptivecards.io/content/cats/1.png");
$image->setHorizontalAligment( \Sebbmyr\Teams\Cards\Adaptive\Styles::HORIZONTAL_ALIGNMENT_CENTER)
    ->setSize( \Sebbmyr\Teams\Cards\Adaptive\Styles::IMAGE_SIZE_MEDIUM)
;
$openUrl = new \Sebbmyr\Teams\Cards\Adaptive\Actions\OpenUrl
$openUrl = new \Sebbmyr\Teams\Cards\Adaptive\Actions\OpenUrl("https://github.com/sebbmeyer/php-microsoft-teams-connector");
    $openUrl->setTitle("Open Github");
// create card
$card = new \Sebbmyr\Teams\Cards\Adaptive\CustomAdaptiveCard();
$card->addElement($textBlockA)
    ->addElement($textBlockB)
    ->addElement($image)
    ->addAction($openUrl)
;
// send card via connector
$connector->send($card);
```

You can find more information about supported elements and actions [here](docs/adaptiveCards.md).

### Other supported card format

To learn more about other supported card format like e.g. `HeroCard` take a look at the documentation [here](docs/otherCards.md).

## Supported frameworks

Currently supported frameworks:

* [Laravel-Teams-Connector](https://github.com/sebbmeyer/laravel-teams-connector)

**If you build a package for an another framework like Yii2, Symphony, ... based on this package. Feel free to submit an PR I will add it to the list**

This is an example of a [Laravel Forge deployment card](https://github.com/sebbmeyer/laravel-teams-connector)

```php
\\ Sebbmyr\LaravelTeams\Cards\ForgeCard.php
public function getMessage()
{
    return [
        "@type" => "MessageCard",
        "@context" => "http://schema.org/extensions",
        "summary" => "Forge Card",
        "themeColor" => ($this->data["status"] === 'success') ? self::STATUS_SUCCESS : self::STATUS_ERROR,
        "title" => "Forge deployment message",
        "sections" => [
            [
                "activityTitle" => "",
                "activitySubtitle" => "",
                "activityImage" => "",
                "facts" => [
                    [
                        "name" => "Server:",
                        "value" => $this->data["server"]['name']
                    ],
                    [
                        "name" => "Site",
                        "value" => "[". $this->data["site"]["name"] ."](http://". $this->data["site"]["name"] .")"
                    ],                        [
                        "name" => "Commit hash:",
                        "value" => "[". $this->data["commit_hash"] ."](". $this->data["commit_url"] .")"
                    ],
                    [
                        "name" => "Commit message",
                        "value" => $this->data["commit_message"]
                    ]
                ],
                "text" => ($this->data["status"] === 'success') ? $this->data["commit_author"] ." deployed some fresh code!" : "Something went wrong :/"
            ]
        ]
    ];
}
```

## License

This PHP Microsoft Teams connector is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
