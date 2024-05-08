<?php

namespace App\Controller;

use App\Card\Card;
use App\Card\CardHand;
use App\Card\DeckOfCards;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CardGameController extends AbstractController
{
    #[Route("/card", name: "card")]
    public function card(): Response
    {   
        return $this->render('card.html.twig');
    }

    #[Route("/card/deck", name: "card_deck")]
    public function showDeck(SessionInterface $session): Response
    {
        $deck = $session->get('deck', new DeckOfCards());

        return $this->render('deck.html.twig', [
            'cards' => $deck->getCards()
        ]);
    }
}
