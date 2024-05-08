<?php
namespace App\Card;

class DeckOfCards {
    private $cards;

    public function __construct() {
        $this->cards = [];
        $suits = ['♥', '♦', '♣', '♠'];
        $values = ['A', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K'];

        foreach ($suits as $suit) {
            foreach ($values as $value) {
                $this->cards[] = new Card($suit, $value);
            }
        }
    }

    public function shuffleDeck() {
        shuffle($this->cards);
    }

    public function drawCard() {
        return array_pop($this->cards);
    }

    public function getRemainingCardsCount() {
        return count($this->cards);
    }
    
    public function getCards() {
        return $this->cards;
    }
    public function getDeckAsString() {
        $deckString = '';
        foreach ($this->cards as $card) {
            $deckString .= $card->getAsString() . ', ';
        }
        
        $deckString = rtrim($deckString, ', ');

        return $deckString;
    }
}
