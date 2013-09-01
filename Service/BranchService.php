<?php

namespace StashApiBundle\Service;

/**
 * Service class that handles branches.
 */
class BranchService extends AbstractService
{
    /**
     * Search for a specific branch in a specified project and repository.
     *
     * @param string $repository
     * @param string $project
     * @param string $branch
     *
     * @return false|array
     */
    public function searchBranch($project, $repository, $branch)
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
