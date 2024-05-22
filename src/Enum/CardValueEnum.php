<?php

namespace App\Enum;

enum CardValueEnum: string
{
    case Two = '2';
    case Three = '3';
    case Four = '4';
    case Five = '5';
    case Six = '6';
    case Seven = '7';
    case Eight = '8';
    case Nine = '9';
    case Ten = '10';
    case Jack = 'J';
    case Queen = 'Q';
    case King = 'K';
    case Ace = 'A';

    public function getNumericValue(): int
    {
        return match($this) {
            self::Two => 2,
            self::Three => 3,
            self::Four => 4,
            self::Five => 5,
            self::Six => 6,
            self::Seven => 7,
            self::Eight => 8,
            self::Nine => 9,
            self::Ten, self::Jack, self::Queen, self::King => 10,
            self::Ace => 11,
        };
    }
}