<?php
namespace App\Entity;

use App\Enum\CardValueEnum;

class PlayerHand
{
    /** @var CardValueEnum[] */
    public array $cards = [];

    public function __construct(CardValueEnum ...$cards)
    {
        $this->cards = $cards;
    }

    public function getCardsCount(): int
    {
        return count($this->cards);
    }

    /**
     * @return CardValueEnum[]
     */
    public function getCards(): array
    {
        return $this->cards;
    }


}