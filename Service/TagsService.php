<?php

namespace StashApiBundle\Service;

use Guzzle\Http\Client;

/**
 * Service class that deals with 'tags' related stash apis.
 */
class TagsService extends AbstractService
{    
    /**
     * Retrieve tags from given repository.
     *
     * @param string $project
     * @param string $repository
     * @param array $params
     *
     * @return null|array
     */
    public function getTags($project, $repository, $params = array())
    {
        $url = $this->createUrl(
            $project,
            $repository,
            'tags',
            $params
        );
        $data = $this->getResponseAsArray($url);
        if (false === isset($data['values'])) {
            return null;
        }

        return $data['values'];
    }
}
