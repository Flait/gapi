<?php
namespace App\Tests\Controller;

use App\Controller\BlackjackController;
use App\Entity\DealerHand;
use App\Entity\PlayerHand;
use App\Enum\CardValueEnum;
use App\Payload\BlackjackRecommendationPayload;
use App\Serializer\PlayerHandDenormalizer;
use App\Service\BlackjackDecisionService;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

#[CoversClass(BlackjackController::class)]
#[UsesClass(DealerHand::class)]
#[UsesClass(PlayerHand::class)]
#[UsesClass(CardValueEnum::class)]
#[UsesClass(BlackjackRecommendationPayload::class)]
#[UsesClass(PlayerHandDenormalizer::class)]
#[UsesClass(BlackjackDecisionService::class)]
class BlackjackControllerTest extends WebTestCase
{
    public function testSuccessfulRecommendation(): void
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/blackjack/recommendation', [], [], [],
            '{
                        "playerHand": {
                            "cards": ["2","A"]
                        },
                        "dealerHand": {
                            "card": "A"
                        }
                    }');

        $this->assertResponseIsSuccessful($client->getResponse());
    }

    public function testInvalidJsonRecommendation(): void
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/blackjack/recommendation', [], [], [],
            '{
                        "playerHand": {
                            "cards": ["2","A"]
                        },
                        "dealerHand": {
                            "card": "
                        }
                    }');

        $this->assertEquals('{"error":"Invalid JSON data"}', $client->getResponse()->getContent());
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
    }
}