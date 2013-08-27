<?php

namespace StashApiBundle\Service;

/**
 * Service class that handles branches in Stash.
 */
class BranchService extends AbstractService
{
    /**
     * Retrieve branches for a specified project, repository and branch.
     *
     * @param string $repository
     * @param string $project
     * @param string $branch
     *
     * @return false|array
     */
    public function getAll($repository, $project, $branch)
    {
        $url = $this->createUrl(
            $project,
            $repository,
            'branches',
            array(
                'filterText' => $branch
            )
        );

        return $this->getResponseAsArray($url);
    }
}
