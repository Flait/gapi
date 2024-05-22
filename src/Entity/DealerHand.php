<?php
namespace App\Entity;

use App\Enum\CardValueEnum;

class DealerHand
{
    public function __construct(private CardValueEnum $card)
    {
    }

    /**
     * @return CardValueEnum
     */
    public function getCard(): CardValueEnum
    {
        return $this->card;
    }


}