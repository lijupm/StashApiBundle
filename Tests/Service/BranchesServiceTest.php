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

    public function testGetCommitsFromBranch()
    {
        $branchJsonFile = __DIR__ . '/../assets/response/branch.json';
        $branchService = new BranchesService($this->getClientMock($branchJsonFile));
        $branches = $branchService->searchBranch('develop', 'sample', 'samplerepo');

        $this->assertEquals('develop', $branches[0]['displayId']);
        $this->assertCount(2, $branches);
    }
}
