<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuoteControllerJson
{

    #[Route("/api/quote")]
    public function jsonCitat(): Response
    {
        
        $quotes = [
            "1" => "Den längsta resan för var och en är den inre resan. - Dag Hammarskjöld",
            "2" => "Alla människor borde behandlas som luft - något absolut livsnödvändigt. - Stig Johansson",
            "3" => "Allt stort som skedde i världen skedde först i någon människas fantasi. - Astrid Lindgren",
            "4" => "Blommorna äro växternas blottade kärlek - Carl von Linné",
            "5" => "Folks längtan efter frihet kan i det långa loppet inte slås ner. Den kommer att leva och segra till sist. -Olof Palme"
        ];

        
        $selectedQuote = array_rand($quotes);
        $today = date("Y-m-d");
        $timestamp = date("H:i:s");

        $data = [
            'quote' => $quotes[$selectedQuote],
            'date' => $today,
            'time' => $timestamp
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }
}