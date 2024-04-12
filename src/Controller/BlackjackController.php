<?php

namespace App\Controller;

use App\Entity\Hand;
use App\Service\BlackjackDecisionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
#[\Symfony\Component\Routing\Attribute\Route('/blackjack')]
class BlackjackController extends AbstractController
{
    public function __construct(
        private SerializerInterface $serializer,
        private BlackjackDecisionService $blackjackDecisionService)
    {
    }

    #[\Symfony\Component\Routing\Attribute\Route('/recommendation', methods: ['GET'])]
    public function getRecommendation(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        $playerHand = $this->serializer->deserialize(json_encode($data['player']), Hand::class, 'json');
        $dealerHand = $this->serializer->deserialize(json_encode($data['dealer']), Hand::class, 'json');

        $decision = $this->blackjackDecisionService->getDecision($playerHand, $dealerHand);

        return $this->json([
            'recommendation' => $decision,
            "status" => "success"
        ]);
    }
}