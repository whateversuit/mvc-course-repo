<?php

namespace App\Controller;

use App\Card\DeckOfCards;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class DeckControllerJson extends AbstractController
{
    
    #[Route ("/api/deck", name: "api_deck", methods: ["GET"])]
    public function getDeck(SessionInterface $session): JsonResponse
    {
        $deck = new DeckOfCards();
        $session->set('deck', $deck);
        return $this->json($deck);
    }


    #[Route ("/api/deck/shuffle", name: "api_deck_shuffle", methods: ["POST", "GET"])]
    public function shuffleDeck(SessionInterface $session): JsonResponse
    {
        $deck = $this->getOrCreateDeck($session);
        
        $deck->shuffleDeck();
        $session->set('deck', $deck);

        return $this->json($deck->getCards());
    }
    #[Route('/api/deck/draw', name: 'api_deck_draw', methods: ["POST", "GET"])]
    public function drawCard(SessionInterface $session): JsonResponse
    {
        $deck = $this->getOrCreateDeck($session);
        $drawnCard = $deck->drawRandomCard();
        $session->set('deck', $deck);
        
        
        return $this->json([
            'drawnCard' => $drawnCard->getAsString(),
            'remainingCardsCount' => $deck->getRemainingCardsCount()
        ]);
    }

    #[Route("/api/deck/draw/{number<\d+>}", name: "api_deck_draw_number", methods: ["POST", "GET"])]
    public function drawMultipleCards(SessionInterface $session, Request $request, $number): Response
    {
        $number = $request->request->get('number', $number);
        $deck = $this->getOrCreateDeck($session);
        $drawnCards = [];
        
        for ($i = 0; $i < $number; $i++) {
            $drawnCards[] = $deck->drawRandomCard()->getAsString();
        }
        
        $session->set('deck', $deck);
        
        return $this->json([
            'drawnCards' => $drawnCards,
            'remainingCardsCount' => $deck->getRemainingCardsCount()
        ]);
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