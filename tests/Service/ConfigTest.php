<?php

declare(strict_types=1);

namespace Ttskch\Party\Service;

use PHPUnit\Framework\TestCase;

/**
 * @group Config
 */
class ConfigTest extends TestCase
{
    /**
     * @var Config
     */
    protected $SUT;

    protected function setUp() : void
    {
        $this->SUT = new Config(__DIR__ . '/../fixture/config.test.yaml');
    }

    public function testGetPurchaseRates() : void
    {
        $rates = $this->SUT->getPurchaseRates();

        $this->assertSame(1, $rates['pizza']);
        $this->assertSame(1.9798561151079, $rates['beer']);
        $this->assertSame(0.98992805755396, $rates['other_alcohol']);
        $this->assertSame(0.23021582733813, $rates['non_alcohol']);
    }
}
