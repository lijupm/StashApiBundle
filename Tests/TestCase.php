<?php
namespace StashApiBundle\Tests;

abstract class TestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * Performs initialisation at the start of each test.
     */
    protected function setUp()
    {
        parent::setUp();
    }


    /**
     * Performs clean-up operations after each test.
     */
    protected function tearDown()
    {
        parent::tearDown();
    }
}
