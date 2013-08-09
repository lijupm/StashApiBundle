<?php

namespace StashApiBundle\Service;

/**
 * Service class that deals with pull-requests in Stash. 
 */
class PullRequestService extends AbstractService
{               
    /**
     * Retrieve all pull-requests in a given project and repository.
     *
     * @param string $project
     * @param string $repository
     * @param array  $options
     *
     * @return null|array
     */
    public function getAll($project, $repository, $options = array())
    {
        $url = $this->createUrl(
            $project,
            $repository,
            'pull-requests',
            $options
        );
        $data = $this->getResponseAsArray($url);

        if (false === isset($data['values'])) {
            return null;
        }

        return $data['values'];
    }   
}
