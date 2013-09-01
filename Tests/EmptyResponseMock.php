<?php

namespace StashApiBundle\Tests;

/**
 * Mocks empty JSON responses for unit testing purposes.
 */
class EmptyResponseMock
{
    protected $response;

    public function __construct()
    {
    }

    public function json()
    {
        return array(
            'size'       => 0,
            'limit'      => 25,
            'isLastPage' => true,
            'values'     => array(),
            'start'      => 0,
            'filter'     => null

        );
    }
}
