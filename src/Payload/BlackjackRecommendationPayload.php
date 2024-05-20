<?php

namespace App\Payload;

use App\Entity\DealerHand;
use App\Entity\PlayerHand;

final readonly class BlackjackRecommendationPayload
{
    public function __construct(
        public PlayerHand $playerHand,
        public DealerHand $dealerHand,
    )
    {
    }
}