<?php

namespace App\Card;

class JokerDeck extends DeckOfCards
{
    public function __construct()
    {
        parent::__construct();
        $this->addJokers();
    }
    private function addJokers()
    {
        $this->cards = array_merge($this->cards, [
            new Card('O_o', 'Joker '),
            new Card('o_O', 'Joker ')
        ]);
    }
}
