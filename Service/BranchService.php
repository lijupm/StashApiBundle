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
    public function search($project, $repository, $branch)
    {
        $url = $this->createUrl(
            $project,
            $repository,
            'branches',
            array(
                'filterText' => $branch
            )
        );

        return $this->performQuery($url);
    }
}
