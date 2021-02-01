# Other cards

Next to **MessageCard** and **AdaptiveCard** there are other card types that can be used via "Incoming Webhook". But they are often not fully supported yet. This package supports currently only the `HeroCard`.

## HeroCard

The `HeroCard` contains a large image, text and one or more buttons. This card is a rebuild of the [HeroCard](https://docs.microsoft.com/en-us/microsoftteams/platform/task-modules-and-cards/cards/cards-reference#hero-card) described in the Microsoft documentation. But not all properties are supported by connectors. Only the first image is shown when you add multiple images to the _images_ property and the _tap_ property not supported at all.

### Available methods

**setTitle($title)**

Name | Type | Required | Description
--- | --- | --- | ---
title | string | yes | Card title

**setSubtitle($subtitle)**

Name | Type | Required | Description
--- | --- | --- | ---
subtitle | string | yes | Subtitle of the card

**setText($text)**

Name | Type | Required | Description
--- | --- | --- | ---
text | string | yes | Card description text shown below the image

**addButton($type, $title, $value)**

Name | Type | Required | Description
--- | --- | --- | ---
type | string | yes | Type of action that should be performed on button click, e.g. "openUrl"
title | string | yes | Button label
value | string | yes | Can be the url which should be opened on button click

**addImage($url)**

__Caution:__ you can add multiple images but only the first one will be displayed

Name | Type | Required | Description
--- | --- | --- | ---
url | string | yes | Url for the image that should be displayed.

### Usage

Here is an example on how to use a `HeroCard`:

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
