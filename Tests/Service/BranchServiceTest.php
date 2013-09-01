<?php

namespace StashApiBundle\Tests\Service;

use StashApiBundle\Tests\TestCase;
use StashApiBundle\Service\BranchService;

class BranchServiceTest extends TestCase
{
    public function testBranchServiceSearchBranch()
    {
        $branchJsonFile = __DIR__ . '/../assets/response/branch.json';

        $service = new BranchService(
            $this->getClientMock(
                $branchJsonFile
            )
        );

        $service->setLimit(1000);
        $branches = $service->searchBranch('PROJECT', 'repository', 'branch');

        $this->assertEquals(0, $service->getStart());
        $this->assertEquals(2, $service->getSize());
        $this->assertEquals(true, $service->isLastPage());

        $this->assertEquals('develop', $branches[0]['displayId']);
        $this->assertCount(2, $branches);
    }

    public function testBranchServiceSearchBranchException()
    {
        $service = new BranchService($this->getClientExceptionMock());

        $result = $service->searchBranch('PROJECT', 'repository', 'branch');

        $this->assertEquals(false, $result);
    }

    public function testBranchServiceSearchBranchNoData()
    {
        $service = new BranchService($this->getClientNoDataMock());

        $result = $service->searchBranch('PROJECT', 'repository', 'branch');

        $this->assertEquals(false, $result);
    }
}
