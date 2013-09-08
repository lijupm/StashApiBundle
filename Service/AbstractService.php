<?php

namespace StashApiBundle\Service;

use Guzzle\Http\Client;
use Guzzle\Http\Exception\BadResponseException;

/**
 * Base class that provides common functionality for all services in the bundle.
 */
abstract class AbstractService
{
    /**
     * @var int
     */
    protected $limit = 10000;

    /**
     * @var int
     */
    protected $start = 0;

    /**
     * @var \Guzzle\Http\Client
     */
    protected $client;

    /**
     * @var \Guzzle\Http\Message\Response
     */
    protected $response;

    /**
     * @var array
     */
    protected $result;

    /**
     * Constructor. 
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Creates and returns a compatible URL.
     *
     * @param string $project
     * @param string $repository
     * @param string $path
     * @param array  $params
     *
     * @return string
     */
    protected function createUrl($project, $repository, $path = '', $params = array())
    {
        $paramString = http_build_query(
            array_merge(
                $params,
                array(
                    'limit' => $this->limit,
                    'start' => $this->start
                )
            )
        );

        $url = sprintf(
            'projects/%s/repos/%s/%s?%s',
            $project,
            $repository,
            $path,
            $paramString
        );

        return $url;
    }

    /**
     * Performs the specified query and stores the result.
     *
     * @param string $url
     *
     * @return bool|array
     */
    protected function performQuery($url)
    {
        $request = $this->client->get($url);

        $this->response = $request->send();

        return $this->getResponseAsArray();
    }

    /**
     * Set the result limit.
     *
     * @param int $limit
     *
     * @return \StashApiBundle\Service\AbstractService
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * Retrieve the result limit.
     *
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * Returns the start of the current result page.
     *
     * @param int $start
     *
     * @return \StashApiBundle\Service\AbstractService
     */
    public function setStart($start)
    {
        $this->start = $start;

        return $this;
    }

    /**
     * Returns the start of the current result page.
     *
     * @return int
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Get response as an array, returns false if no result.
     *
     * @param bool|array
     */
    private function getResponseAsArray()
    {
        $this->result = $this->response->json();

        if ($this->responseHasErrors()) {
            return false;
        }

        return $this->result;
    }

    /**
     * Indicates whether the current result page contains errors.
     * 
     * @return bool
     */
    private function responseHasErrors()
    {
        return array_key_exists('errors', $this->result);
    }
}
