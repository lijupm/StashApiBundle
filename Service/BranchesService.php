<?php

namespace StashApiBundle\Service;

/**
 * Service class that deals with 'branch' related stash apis.
 */
class BranchesService extends AbstractService
{
    /**
     * Search branches in a given project repository.
     *
     * @param string $branch
     * @param string $project
     * @param string $repository
     *
     * @return null|array
     */
    public function searchBranch($branch, $project, $repository)
    {
        $url = $this->createUrl(
            $project,
            $repository,
            'branches',
            array(
                'filterText' => $branch
            )
        );
        $data = $this->getResponseAsArray($url);

        if (false === isset($data['values'])) {
            return null;
        }

        return $data['values'];
    }
}
