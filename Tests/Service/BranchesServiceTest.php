<?php

namespace StashApiBundle\Tests\Service;

use StashApiBundle\Tests\TestCase;
use StashApiBundle\Service\BranchesService;

class BranchesServiceTest extends TestCase
{
    public function testGetCommitsFromBranch()
    {
        $branchJsonFile = __DIR__ . '/../assets/response/branch.json';
        $branchService = new BranchesService($this->getClientMock($branchJsonFile));
        $branches = $branchService->searchBranch('develop', 'sample', 'samplerepo');

        $this->assertEquals('develop', $branches[0]['displayId']);
        $this->assertCount(2, $branches);
    }
}
