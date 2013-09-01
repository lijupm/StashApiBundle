<?php

namespace StashApiBundle\Service;

use Guzzle\Http\Client;

/**
 * Base class that provides common functionality for all services in the bundle.
 */
abstract class AbstractService
{
    /**
     * @var bool
     */
    private $lastPage = false;

    /**
     * @var int
     */
    private $size = 0;

    /**
     * @var int
     */
    private $limit = 10000;

    /**
     * @var int
     */
    private $start = 0;

    /**
     * @var \Guzzle\Http\Client
     */
    protected $client;

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

        $this->start = 0;
        $this->size = 0;
        $this->lastPage = false;

        return $url;
    }

    /**
     * Get response as an array, returns false if no result.
     *
     * @param string $url
     *
     * @return bool|array
     */
    protected function getResponseAsArray($url)
    {
        $request = $this
            ->client
            ->get($url);

        $result = $request
            ->send()
            ->json();

        $this->lastPage = $result['isLastPage'];
        $this->size = $result['size'];

        if (!$this->lastPage) {
            $this->start += $this->limit;
        }

        if ($this->resultHasData($result)) {
            return $result['values'];
        }

        return false;
    }

    /**
     * Set the result limit.
     *
     * @param integer $limit
     *
     * @return self
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * Returns the size of the current result page.
     *
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Indicates whether the current page is the last result page.
     *
     * @return bool
     */
    public function isLastPage()
    {
        return $this->lastPage;
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
     * Indicates whether the current result page contains data.
     *
     * @param $result
     *
     * @return bool
     */
    private function resultHasData($result)
    {
        return (array_key_exists('values', $result) && count($result['values']) > 0);
    }
}
