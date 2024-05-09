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
        $deck = $this->getOrCreateDeck($session);

        return $this->render('deck.html.twig', [
            'cards' => $deck->getCards()
        ]);
    }

    #[Route("/card/deck/shuffle", name: "card_deck_shuffle")]
    public function shuffleDeck(SessionInterface $session): Response
    {
        $deck = new DeckOfCards();
        $deck->shuffleDeck();
        $session->set('deck', $deck);


        return $this->redirectToRoute('card_deck');
    }

    #[Route("/card/deck/draw", name: "card_deck_draw")]
    public function drawCard(SessionInterface $session): Response
    {
        $deck = $this->getOrCreateDeck($session);
        $randomCard = $deck->drawRandomCard();
        $remainingCardsCount = $deck->getRemainingCardsCount();


        return $this->render('draw.html.twig', [

            'randomCard' => $randomCard,
            'remainingCardsCount' => $remainingCardsCount
        ]);

    }
    #[Route("/card/deck/draw/{number}", name: "card_deck_draw_number")]
    public function drawMultipleCards(SessionInterface $session, $number): Response
    {
        $deck = $this->getOrCreateDeck($session);
        $hand = $session->get('hand', new CardHand());

        for ($i = 0; $i < $number; $i++) {
            $hand->addCard($deck->drawRandomCard());
        }

        $session->set('deck', $deck);
        $session->set('hand', $hand);

        return $this->render('draw_hand.html.twig', [
            'drawnCards' => $hand->getCards(),

        ]);
    }

    private function getOrCreateDeck(SessionInterface $session): DeckOfCards
    {
        if (!$session->has('deck')) {
            $deck = new DeckOfCards();
            $session->set('deck', $deck);
        } else {
            $deck = $session->get('deck');
        }

        return $deck;
    }
}
