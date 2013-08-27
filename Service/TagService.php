<?php

namespace StashApiBundle\Service;

use Guzzle\Http\Client;

/**
 * Service class that deals with 'tags' related stash apis.
 */
class TagService extends AbstractService
{    
    /**
     * Retrieve tags from given repository.
     *
     * @param string $project
     * @param string $repository
     * @param array  $params
     *
     * @return null|array
     */
    public function getAll($project, $repository, $params = array())
    {
        $url = $this->createUrl(
            $project,
            $repository,
            'tags',
            $params
        );

        return $this->getResponseAsArray($url);
    }
}
