<?php

namespace App\Controller;

use App\Payload\BlackjackRecommendationPayload;
use App\Service\BlackjackDecisionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
        try {
            $payload = $this->serializer->deserialize($request->getContent(), BlackjackRecommendationPayload::class, 'json');
        } catch (\Exception $e) {
            return $this->json(['error' => 'Invalid JSON data'], Response::HTTP_BAD_REQUEST);
        }

        $decision = $this->blackjackDecisionService->getDecision($payload);

        return $this->json([
            'recommendation' => $decision,
            "status" => "success",
        ]);
    }
}