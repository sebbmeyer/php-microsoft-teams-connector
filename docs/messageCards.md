# MessageCard

This package contains two predefined cards for the **MessageCard** format that you can use `SimpleCard` and `CustomCard`.

## SimpleCard

The `SimpleCard` only has a title and text which are passed in the constructor as an array.

### Usage

```php
// create connector instance
$connector = new \Sebbmyr\Teams\TeamsConnector(<INCOMING_WEBHOOK_URL>);
// create card
$card  = new \Sebbmyr\Teams\Cards\SimpleCard([
    'title' => 'Simple card title',
    'text' => 'Simple card text',
]);
// send card via connector
$connector->send($card);
```

## CustomCard

The `CustomCard` is a pretty flexible card base on the **MessageCard** type.

### Available methods

### Usage

Here is an example on how to use a `CustomCard`:

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
