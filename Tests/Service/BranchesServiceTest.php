<?php

namespace StashApiBundle\Tests\Service;

use StashApiBundle\Tests\TestCase;
use StashApiBundle\Service\BranchesService;

class BranchesServiceTest extends TestCase
{
    public function testSearchBranch()
    {
        $jsonFile = __DIR__ . '/../assets/response/branches.json';

        $service = new BranchesService($this->getClientMock($jsonFile));
        $pullRequests = $service->searchBranch('develop', 'mcis', 'mcis');

        $this->assertCount(25, $pullRequests);
    }
}
