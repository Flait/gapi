<?php

use PHPUnit\Framework\TestCase;
use App\Service\BlackjackDecisionService;
use App\Entity\DealerHand;
use App\Entity\PlayerHand;
use App\Enum\CardValueEnum;
use App\Payload\BlackjackRecommendationPayload;
use PHPUnit\Framework\Attributes\CoversClass;
#[CoversClass(BlackjackDecisionService::class)]
#[CoversClass(PlayerHand::class)]
#[CoversClass(DealerHand::class)]
#[CoversClass(CardValueEnum::class)]
#[CoversClass(BlackjackRecommendationPayload::class)]
final class BlackjackDecisionServiceTest extends TestCase
{
    public function testGetDecisionHit(): void
    {
        $playerHand = new PlayerHand([CardValueEnum::Two, CardValueEnum::Nine]); // Total: 11
        $dealerHand = new DealerHand(CardValueEnum::Five); // Dealer card is 5

        $payload = new BlackjackRecommendationPayload($playerHand, $dealerHand);

        $service = new BlackjackDecisionService();
        $decision = $service->getDecision($payload);

        $this->assertEquals('hit', $decision);
    }

    public function testGetDecisionStand(): void
    {
        $playerHand = new PlayerHand([CardValueEnum::Ten, CardValueEnum::Seven]); // Total: 17
        $dealerHand = new DealerHand(CardValueEnum::Six); // Dealer card is 6

        $payload = new BlackjackRecommendationPayload($playerHand, $dealerHand);

        $service = new BlackjackDecisionService();
        $decision = $service->getDecision($payload);

        $this->assertEquals('stand', $decision);
    }

    public function testCalculateHandTotal(): void
    {
        $playerHand = new PlayerHand([CardValueEnum::Ace, CardValueEnum::Nine]); // Total: 20

        $service = new BlackjackDecisionService();
        $total = $service->calculateHandTotal($playerHand);

        $this->assertEquals(20, $total);
    }

    public function testCalculateHandTotalWithAceAdjustment(): void
    {
        $playerHand = new PlayerHand([CardValueEnum::Ace, CardValueEnum::Ace, CardValueEnum::Nine]); // Total: 21

        $service = new BlackjackDecisionService();
        $total = $service->calculateHandTotal($playerHand);

        $this->assertEquals(21, $total);
    }
}
