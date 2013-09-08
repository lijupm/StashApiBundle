<?php

namespace StashApiBundle\Service;

use Guzzle\Http\Client;

/**
 * Service class that handles tags.
 */
class TagService extends AbstractService
{
    /**
     * Retrieve tags from specified project and repository.
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

        return $this->performQuery($url);
    }
}
