<?php

namespace Stef\DagVanDeWeekBundle\Tests\Controller;

use Stef\DagVanDeWeekBundle\Controller\HistoryController;

class HistoryControllerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test if a response will be returned which contains a redirect to a month and day
     * with two digits (with leading zero's)
     */
    public function testResponse()
    {
        $controller = new HistoryController();

        $response = $controller->showByYearMonthDayAction(1940, 1, 1);

        $this->assertEquals('/historie/1940/01/01', $response->getTargetUrl());
    }
}
