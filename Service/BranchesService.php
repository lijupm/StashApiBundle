<?php

namespace StashApiBundle\Service;

use Guzzle\Http\Client;

/**
 * Service class that deals with 'branch' related stash apis.
 * 
 * @author Liju.P.M <liju.p.mohanan@medicore.nl>
 */
class BranchesService extends AbstractService
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
