<?php

namespace StashApiBundle\Service;

use Guzzle\Http\Client;

/**
 * Service class that deals with 'files' related stash apis.
 * 
 * @author Liju.P.M <liju.p.mohanan@medicore.nl>
 */
class FilesService extends BaseService
{ 
    
    /**
     *
     * @var Guzzle\Http\Client 
     */
    protected $client;
    
    /**
     * Constructor. 
     */
    public function __construct(Client $client)
    {         
        $this->client = $client;        
    }        

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
    public function getFilesFromBranch($project, $repository, $branch, $path)
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
