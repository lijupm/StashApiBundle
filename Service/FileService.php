<?php

namespace StashApiBundle\Service;

/**
 * Service class that handles files in Stash.
 */
class FileService extends AbstractService
{
    /**
     * Get files in specified path for specified reference.
     *
     * @param string $project
     * @param string $repository
     * @param string $reference
     * @param string $path
     *
     * @return null|array
     */
    public function getAll($project, $repository, $reference, $path = '.')
    {
        $url = $this->createUrl(
            $project,
            $repository,
            sprintf('files/%s', $path),
            array(
                'at' => $reference
            )
        );

        return $this->performQuery($url);
    }
}
