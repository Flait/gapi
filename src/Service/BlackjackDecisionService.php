<?php

namespace App\Service;

use App\Entity\Hand;
use App\Enum\CardValueEnum;

class BlackjackDecisionService
{
    private const HIT = 'hit';
    private const STAND = 'stand';
    private const DECISION_MATRIX = [
        // Player's hand values as keys; dealer's card 2-9(0-7),10(8),A(9) as sub-array values
        11 => ['H', 'H', 'H', 'H', 'H', 'H', 'H', 'H', 'H', 'H'], // Player's hand is 11 or less
        12 => ['H', 'H', 'S', 'S', 'S', 'H', 'H', 'H', 'H', 'H'], // Player's hand is 12
        13 => ['S', 'S', 'S', 'S', 'S', 'H', 'H', 'H', 'H', 'H'], // Player's hand is 13
        14 => ['S', 'S', 'S', 'S', 'S', 'H', 'H', 'H', 'H', 'H'], // Player's hand is 14
        15 => ['S', 'S', 'S', 'S', 'S', 'H', 'H', 'H', 'H', 'H'], // Player's hand is 15
        16 => ['S', 'S', 'S', 'S', 'S', 'H', 'H', 'H', 'H', 'H'], // Player's hand is 16
        17 => ['S', 'S', 'S', 'S', 'S', 'S', 'S', 'S', 'S', 'S'], // Player's hand is 17 or more
    ];

    public function getDecision(Hand $playerHandValue, Hand $dealerHand): string
    {
        if ($dealerHand->getCardsCount() === 1) {
            $dealerCardIndex = $dealerHand->cards[0]->getNumericValue() - 2;
        } else {
            throw new \Error();
        }

        $playerHandValue = min(
            max($this->calculateHandTotal($playerHandValue), 11),
            17
        );

        $decisionChar = self::DECISION_MATRIX[$playerHandValue][$dealerCardIndex] ??
            throw new \Error();

        return $decisionChar === 'H' ? self::HIT : self::STAND;
    }

    public function calculateHandTotal(Hand $hand): int
    {
        $total = 0;
        $aces = 0;

        foreach ($hand->getCards() as $card) {
            if ($card === CardValueEnum::Ace) {
                ++$aces;
                $total += 11;
            } else {
                $total += $card->getNumericValue();
            }
        }

        // Adjust for Aces if total is over 21
        while ($total > 21 && $aces > 0) {
            $total -= 10; // Counting an Ace as 1 instead of 11
            --$aces;
        }

        return $total;
    }
}