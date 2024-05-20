<?php

namespace App\Serializer;

use App\Entity\PlayerHand;
use App\Enum\CardValueEnum;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class PlayerHandDenormalizer implements DenormalizerInterface
{
    /**
     * @param mixed[] $context
     */
    public function denormalize($data, $type, $format = null, array $context = []): PlayerHand
    {
        if (!is_array($data) || !is_array($data['cards']) || empty($data['cards'])) {
            throw new UnexpectedValueException('Invalid data for PlayerHand.');
        }

        $cards = [];
        foreach ($data['cards'] as $cardValue) {
            try {
                $cards[] = CardValueEnum::from($cardValue);
            } catch (\ValueError $e) {
                throw new UnexpectedValueException(sprintf('The value "%s" is not a valid CardValueEnum.', $cardValue));
            }
        }

        return new PlayerHand($cards);
    }

    /**
     * @param mixed[] $context
     */
    public function supportsDenormalization($data, $type, $format = null, array $context = []): bool
    {
        return $type === PlayerHand::class;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            PlayerHand::class => true,
        ];
    }
}
