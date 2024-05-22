<?php

namespace App\Tests\Serializer;

use App\Entity\DealerHand;
use App\Entity\PlayerHand;
use App\Enum\CardValueEnum;
use App\Serializer\PlayerHandDenormalizer;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;


#[CoversClass(PlayerHandDenormalizer::class)]
#[UsesClass(PlayerHand::class)]
final class PlayerHandDenormalizerTest extends TestCase
{

    public function testDenormalize(): void
    {
        $denormalizer = new PlayerHandDenormalizer();
        $playerHand = $denormalizer->denormalize(['cards' => ['2', 'A']], PlayerHand::class);

        $this->assertInstanceOf(PlayerHand::class, $playerHand);
        $this->assertEquals([CardValueEnum::Two, CardValueEnum::Ace], $playerHand->getCards());
    }

    public function testDenormalizeWithInvalidCards(): void
    {
        $denormalizer = new PlayerHandDenormalizer();

        $this->expectExceptionMessage('Provided cards are invalid');
        $denormalizer->denormalize('test', PlayerHand::class);

        $this->expectExceptionMessage('Provided cards are invalid');
        $denormalizer->denormalize([], PlayerHand::class);

        $this->expectExceptionMessage('Provided cards are invalid');
        $denormalizer->denormalize(['cards' => 'test'], PlayerHand::class);

        $this->expectExceptionMessage('Provided cards are invalid');
        $denormalizer->denormalize(['cards' => []], PlayerHand::class);
    }

    public function testDenormalizeWithoutValidCardEnums(): void
    {
        $denormalizer = new PlayerHandDenormalizer();
        $this->expectExceptionMessage('The value "1" is not a valid CardValueEnum.');

        $denormalizer->denormalize(['cards' => ['1']], PlayerHand::class);
    }

    public function testSupportsDenormalization(): void
    {
        $denormalizer = new PlayerHandDenormalizer();
        $this->assertTrue($denormalizer->supportsDenormalization([], PlayerHand::class));
        $this->assertFalse($denormalizer->supportsDenormalization([], DealerHand::class));
    }

    public function testGetSupportedTypes(): void
    {
        $denormalizer = new PlayerHandDenormalizer();
        $this->assertEquals([PlayerHand::class => true], $denormalizer->getSupportedTypes(null));
    }
}