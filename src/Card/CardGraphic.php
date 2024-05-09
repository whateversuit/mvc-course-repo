<?php

namespace App\Card;

class CardGraphic extends Card {
    protected $graphic;

    public function __construct($suit, $value, $graphic) {
        parent::__construct($suit, $value);
        $this->graphic = $graphic;
    }

    public function getGraphic() {
        return $this->graphic;
    }
}