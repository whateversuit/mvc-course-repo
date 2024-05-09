<?php

namespace App\Card;

class CardHand {
    private $cards;

    public function __construct() {
        $this->cards = [];
    }

    public function addCard(Card $card) {
        $this->cards[] = $card;
    }

    public function showHand() {
        foreach ($this->cards as $card) {
            echo $card . ' ';
        }
    }
}
