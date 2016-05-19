<?php

namespace Stefanius\DagVanDeWeekBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

abstract class AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{
    /**
     * Get the order of this fixture.
     *
     * @return int
     */
    public function getOrder()
    {
        return 0;
    }
}
