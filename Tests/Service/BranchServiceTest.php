<?php

namespace StashApiBundle\Tests\Service;

use StashApiBundle\Tests\TestCase;
use StashApiBundle\Service\BranchService;

class BranchServiceTest extends TestCase
{
    public function testBranchServiceSearchBranch()
    {
        $jsonFile = __DIR__ . '/../assets/response/branch.json';

        $service = new BranchService(
            $this->getClientMock($jsonFile)
        );

        $pullRequests = $service->searchBranch('PROJECT', 'repository', 'branch');

        $this->assertCount(2, $pullRequests);
    }

    public function testBranchServiceSearchBranchException()
    {
        $service = new BranchService($this->getClientMockException());

        $result = $service->searchBranch('PROJECT', 'repository', 'branch');

        $this->assertEquals(false, $result);
    }

    public function testBranchServiceSearchBranchNoData()
    {
        $service = new BranchService($this->getClientMockNoData());

        $result = $service->searchBranch('PROJECT', 'repository', 'branch');

        $this->assertEquals(false, $result);
    }
}
