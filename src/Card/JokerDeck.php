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
            new Card('Joker', 'O_o'),
            new Card('Joker', 'o_O')
        ]);
    }
}