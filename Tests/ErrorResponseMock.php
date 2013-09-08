<?php

namespace StashApiBundle\Tests;

/**
 * Mocks empty JSON responses for unit testing purposes.
 */
class ErrorResponseMock
{
    protected $response;

    public function __construct()
    {
    }

    public function json()
    {
        return array(
            'errors' => array(
                "context"       => "name",
                "message"       => "The name should be between 1 and 255 characters.",
                "exceptionName" => null
            )
        );
    }
}
