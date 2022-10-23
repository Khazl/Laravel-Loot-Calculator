# LootCalculator

Helps to pick one out of several possible outcomes, taking into account their probability.  
Like a coin toss, dice roll or lootbox / grab bag.



## Installation

Via Composer

``` bash
$ composer require khazl/loot-calculator
```

## Usage

### Create a loot calculator
```php
    $dice = new LootCalculator();
```

The calculator can either be filled with possible outcomes via the `__construct` or via the `add` method.
Constructor:
The key of this array is the outcome reference. The value is the probability in relation to the other outcomes.

```php
    $dice = new LootCalculator([
        1 => 1,
        2 => 1,
        3 => 1,
        4 => 1,
        5 => 1,
        6 => 1
    ]);
```

Add method:
The first parameter is the outcome reference and the second parameter is the probability in relation to the other outcomes.

```php
    $dice = new LootCalculator();
    $dice->add(1, 1);
    $dice->add(2, 1);
    $dice->add(3, 1);
    $dice->add(4, 1);
    $dice->add(5, 1);
    $dice->add(6, 1);
```

Now we have a loot-calculator with six different outcomes (the faces of a common dice) and all with the same probability.

### Get an outcome

If we now want to draw an outcome, we call the `draw` method on our loot calculator.

```php
    $result = $dice->draw();
```

### Look into the loot calculator

To see the content of an existing loot calculator, two different methods are available.

```php
    $dice->getContent();
    /* returns:
    array:6 [
        1 => 1
        2 => 1
        3 => 1
        4 => 1
        5 => 1
        6 => 1
    ]
    */
```

```php
    $dice->getContentWithPercentages();
    /* returns:
    array:6 [
        1 => 16.666666666667
        2 => 16.666666666667
        3 => 16.666666666667
        4 => 16.666666666667
        5 => 16.666666666667
        6 => 16.666666666667
    ]
    */
```

### Removing outcomes from a loot calculator

If we want to remove an outcome from an already existing loot-calculator, 
we call the `remove` method and pass the outcome reference as property.

```php
    $dice->remove(4);
```

Now the dice would no longer have a four-eyed side.

## Examples
Check `src/Examples`. Some of these examples are ready to use!

### Cooking

In this scenario we are in a game where you can prepare meals. 
Since we are only human and our cooking skills vary slightly, an omelet can turn out differently.

In this case, the outcome references, refer to a specific `Item` entity.

```php
     $omeletteCooking = new LootCalculator([
        'Item:453' => 70, // Omlette - 70%
        'Item:454' => 29, // Burned Omlette - 29%
        'Item:455' => 1, // Perfect Omlette - 1%
    ]);

    $outcome = $omeletteCooking->draw();
```

### Very rare outcomes

To represent very rare outcomes, the probabilities of the other outcomes must be correspondingly higher.
The lowest probability is 1. 
The highest probability is open to the top. The higher you go, the less likely the lowest (1) becomes.

```php
     $omeletteCooking = new LootCalculator([
        'Item:453' => 7000, // Omlette - 70%
        'Item:454' => 2999, // Burned Omlette - 29.99%
        'Item:455' => 1, // Perfect Omlette - 0.01%
    ]);

    $outcome = $omeletteCooking->draw();
```

## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## License

MIT. Please see the [license file](license.md) for more information.
