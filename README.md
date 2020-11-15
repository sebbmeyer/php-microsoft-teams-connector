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
// create connector instance
$connector = new \Sebbmyr\Teams\TeamsConnector(<INCOMING_WEBHOOK_URL>);
// create card
$card  = new \Sebbmyr\Teams\Cards\SimpleCard(['title' => 'Simple card title', 'text' => 'Simple card text']);
// send card via connector
$connector->send($card);
```

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

Or you can create your own cards for every purpose you need, just extend the **AbstractCard** class and implement the `getMessage()` function. This is an example of a [Laravel Forge deployment card](https://github.com/sebbmeyer/laravel-teams-connector)

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

### AdaptiveCard

You can almost every element you can find [here](https://adaptivecards.io/explorer/) except **Action.Submit** and as a consequence **Input** elements are useless at the moment. Currently it can be used in two ways:

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

### HeroCard

The package also support the HeroCard which is described [here](https://docs.microsoft.com/en-us/microsoftteams/platform/task-modules-and-cards/cards/cards-reference#hero-card). *Note:* The card has an images property that is a type of array of images, but only one card is shown. You can use the HeroCard like this:

```php
// create connector instance
$connector = new \Sebbmyr\Teams\TeamsConnector(<INCOMING_WEBHOOK_URL>);
// create card
$card = new \Sebbmyr\Teams\Cards\HeroCard();
$card->setTitle("Hero Card")
    ->setSubtitle("Featuring Deadpool")
    ->addImage("https://miro.medium.com/max/3840/1*0ubYRV_WNR9iYrzUAVINHw.jpeg")
    ->setText("Deadpool is a fictional character appearing in American comic books published by Marvel Comics. Created by writer Fabian Nicieza and artist/writer Rob Liefeld, the character first appeared in The New Mutants #98 (cover-dated February 1991). Initially Deadpool was depicted as a supervillain when he made his first appearance in The New Mutants and later in issues of X-Force, but later evolved into his more recognizable antiheroic persona. Deadpool, whose real name is Wade Winston Wilson, is a disfigured mercenary with the superhuman ability of an accelerated healing factor and physical prowess. The character is known as the \"Merc with a Mouth\" because of his tendency to talk and joke constantly, including breaking the fourth wall for humorous effect and running gags.")
    ->addButton("openUrl", "Wikipedia page", "https://en.wikipedia.org/wiki/Deadpool")
;
// send card via connector
$connector->send($card);
```

## License

This PHP Microsoft Teams connector is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
