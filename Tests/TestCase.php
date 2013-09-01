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
     * Get a Guzzle client mock object which also returns the
     * JSON file as an array in our services.
     *
     * @param string $jsonFile
     *
     * @return Guzzle\Http\Client
     *
     * @throws \RuntimeException
     */
    protected function getClientMock($jsonFile)
    {
        if (false === file_exists($jsonFile)) {
            throw new \RuntimeException('Unable to find JSON file.');
        }

        $request = $this->getMock('Guzzle\Http\Message\RequestInterface');
        $request
            ->expects($this->any())
            ->method('send')
            ->will($this->returnValue(new JsonResponseMock($jsonFile)));

        $client = $this->getMockBuilder('Guzzle\Http\Client')
            ->disableOriginalConstructor()
            ->getMock();

        $client
            ->expects($this->any())
            ->method('get')
            ->will($this->returnValue($request));

        return $client;
    }

    /**
     * Performs clean-up operations after each test.
     */
    protected function tearDown()
    {
        parent::tearDown();
    }
}
