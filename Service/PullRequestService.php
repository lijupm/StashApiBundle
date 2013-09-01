<?php

namespace StashApiBundle\Service;

/**
 * Service class that handles pull requests.
 */
class PullRequestService extends AbstractService
{
    /**
     * Retrieve all pull requests for a specified project and repository.
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
            'pull-requests',
            $params
        );

        return $this->getResponseAsArray($url);
        $this->assertCount(2, $tags);
    }
}
