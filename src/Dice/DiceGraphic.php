<?php

namespace App\Dice;

class DiceGraphic extends Dice
{
    private $representation = [
        '⚀',
        '⚁',
        '⚂',
        '⚃',
        '⚄',
        '⚅',
    ];

    public function __construct()
    {
        parent::__construct(); // konstruktorn i parent-klassen blir anropad.
    }

    public function getAsString(): string
    {
        return $this->representation[$this->value - 1];
    }
}
