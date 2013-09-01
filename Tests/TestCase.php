<?php

namespace StashApiBundle\Tests;

use Guzzle\Http\Exception\BadResponseException;

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
     * Get a Guzzle client mock object which returns the specified
     * JSON file as an array.
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

        $client = $this
            ->getMockBuilder('Guzzle\Http\Client')
            ->disableOriginalConstructor()
            ->getMock();

        $client
            ->expects($this->any())
            ->method('get')
            ->will($this->returnValue($request));

        return $client;
    }

    /**
     * Get a Guzzle client mock object which triggers a BadResponseException.
     *
     * @return Guzzle\Http\Client
     *
     * @throws \RuntimeException
     */
    protected function getClientExceptionMock()
    {
        $request = $this
            ->getMockBuilder('Guzzle\Http\Message\ClientInterface')
            ->setMethods(array('send'))
            ->getMock();

        $request
            ->expects($this->once())
            ->method('send')
            ->will(
                $this
                    ->throwException(
                        new BadResponseException()
                    )
            );

        $client = $this
            ->getMockBuilder('Guzzle\Http\Client')
            ->disableOriginalConstructor()
            ->getMock();

        $client
            ->expects($this->once())
            ->method('get')
            ->will($this->returnValue($request));

        return $client;
    }

    /**
     * Get a Guzzle client mock object which returns no data.
     *
     * @return Guzzle\Http\Client
     *
     * @throws \RuntimeException
     */
    protected function getClientNoDataMock()
    {
        $request = $this->getMock('Guzzle\Http\Message\RequestInterface');
        $request
            ->expects($this->any())
            ->method('send')
            ->will($this->returnValue(new EmptyResponseMock()));


        $client = $this
            ->getMockBuilder('Guzzle\Http\Client')
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
