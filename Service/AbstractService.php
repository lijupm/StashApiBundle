<?php

namespace StashApiBundle\Service;

use Guzzle\Http\Client;

/**
 * Base class that contain common features that is needed by other classes.
 */
abstract class AbstractService
{ 
    /**
     * @var Guzzle\Http\Client
     */
    protected $client;

    /**
     * @var int
     */
    protected $resultLimit = 100;

    /**
     * Constructor. 
     */
    public function __construct(Client $client)
    {         
        $this->client = $client;        
    } 
    
    /**
     * Set the maximum number of results being fetched from the REST api.
     *
     * @param integer $limit
     *
     * @return self
     */
    public function setResultLimit($limit)
    {
        $this->resultLimit = $limit;

        return $this;
    }
    
    /**
     * Creates and returns an stash compatible URL
     *
     * @param string $project
     * @param string $repository
     * @param array  $params
     *
     * @return string
     */
    protected function createUrl($project, $repository, $path, array $params = array())
    {
        $url = sprintf('projects/%s/repos/%s/%s', $project, $repository, $path);
        $params = array_merge($params, array('limit' => $this->resultLimit));
        $url = $url . '?' . http_build_query($params);

        return $url;
    }
    
    /**
     * Get response from Stash for the given API call.
     *
     * @param string $url
     *
     * @return array
     */
    protected function getResponseAsArray($url)
    {
        $request = $this->client->get($url);
        $response = $request->send();

        return $response->json();
    }
}    