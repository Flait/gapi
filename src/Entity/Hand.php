<?php
namespace App\Entity;

use App\Enum\CardValueEnum;

class Hand
{
    /** @var CardValueEnum[] */
    public array $cards = [];

    public function __construct(CardValueEnum ...$cards)
    {
        $this->cards = $cards;
    }

    public function addCard(CardValueEnum $card): void
    {
        $this->cards[] = $card;
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