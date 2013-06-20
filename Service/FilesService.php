<?php

namespace StashApiBundle\Service;

/**
 * Service class that deals with 'files' related stash apis.
 */
class FilesService extends AbstractService
{
    /**
     * Get files from given branch from given path.
     *
     * @param string $project
     * @param string $repository
     * @param string $branch
     * @param string $path
     *
     * @return null|array
     */
    public function getFilesFromBranch($project, $repository, $branch, $path='.')
    {
        $url = $this->createUrl(
            $project,
            $repository,
            sprintf('files/%s', $path),
            array(
                'at' => $branch
            )
        );
        $data = $this->getResponseAsArray($url);

        if (false === isset($data['values'])) {
            return null;
        }

        return $data['values'];
    }
}
