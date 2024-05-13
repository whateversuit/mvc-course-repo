<?php

namespace App\Controller;

use App\Card\Card;
use App\Card\CardHand;
use App\Card\DeckOfCards;
use App\Card\JokerDeck;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

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

    #[Route("/card/deck/shuffle", name: "card_deck_shuffle", )]
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
    #[Route("/card/deck/draw/{number<\d+>}", name: "card_deck_draw_number", methods: ["POST"])]
    public function drawMultipleCards(SessionInterface $session, Request $request, $number): Response
    {
        $number = $request->request->get('number', $number);
        $deck = $this->getOrCreateDeck($session);
        $hand = $session->get('hand', new CardHand());

        for ($i = 0; $i < $number; $i++) {
            $hand->addCard($deck->drawRandomCard());
        }
        $remainingCardsCount = $deck->getRemainingCardsCount();
        $session->set('deck', $deck);
        $session->set('hand', $hand);

        return $this->render('draw_hand.html.twig', [
            'drawnCards' => $hand->getCards(),
            'remainingCardsCount' => $remainingCardsCount

        ]);
    }

    #[Route("/card/deck/jokers", name: "card_deck_jokers")]
    public function initializeDeckWithJokers(SessionInterface $session): Response
    {
        $deck = new JokerDeck();
        $session->set('deck', $deck);

        return $this->redirectToRoute('card_deck');
    }


    private function getOrCreateDeck(SessionInterface $session): DeckOfCards
    {
        if (!$session->has('deck')) {
            $deck = new DeckOfCards();
            $session->set('deck', $deck);
        } else {
            $deck = $session->get('deck');
            if (!$deck instanceof DeckOfCards) {
                $deck = new DeckOfCards();
                $session->set('deck', $deck);
            }
        }

        return $deck;
    }
}
