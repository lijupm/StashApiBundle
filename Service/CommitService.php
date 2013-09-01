<?php

namespace StashApiBundle\Service;

use Guzzle\Http\Client;

/**
 * Service class that handles commits.
 */
class CommitService extends AbstractService
{
    /**
     * Constructor. 
     * 
     * @param \Guzzle\Http\Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Retrieve commits from a specified branch, returns false if none found.
     *
     * @param string $project
     * @param string $repository
     * @param array  $params
     *
     * @return bool|array
     */
    public function getAll($project, $repository, $params = array())
    {
        $url = $this->createUrl(
            $project,
            $repository,
            'commits',
            $params
        );

        return $this->getResponseAsArray($url);
    }
}
