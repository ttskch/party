<?php

declare(strict_types=1);

namespace Ttskch\Party;

use PHPUnit\Framework\TestCase;

class PartyTest extends TestCase
{
    /**
     * @var Party
     */
    protected $party;

    protected function setUp() : void
    {
        $this->party = new Party;
    }

    public function testIsInstanceOfParty() : void
    {
        $actual = $this->party;
        $this->assertInstanceOf(Party::class, $actual);
    }
}
