<?php
namespace App\Entity;

use App\Enum\CardValueEnum;

class PlayerHand
{
    /** @var non-empty-array<CardValueEnum> */
    private array $cards;

    /** @param non-empty-array<CardValueEnum> $cards*/
    public function __construct(array $cards)
    {
        $this->cards = $cards;
    }

    /**
     * @return non-empty-array<CardValueEnum>
     */
    public function getCards(): array
    {
        return $this->cards;
    }
}