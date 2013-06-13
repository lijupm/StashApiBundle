<?php

namespace StashApiBundle\Tests\Service;

use StashApiBundle\Tests\TestCase;
use StashApiBundle\Service\CommitsService;
use StashApiBundle\Service\BranchesService;

class CommitsServiceTest extends TestCase
{
    public function testGetCommitsFromBranch()
    {
        $commitJsonFile = __DIR__ . '/../assets/response/commits.json';
        $branchJsonFile = __DIR__ . '/../assets/response/branch.json';
        $branchService = new BranchesService($this->getClientMock($branchJsonFile));
        $commitService = new CommitsService($this->getClientMock($commitJsonFile), $branchService);
        $params = array(
            'until' => 'refs/heads/develop'
        );
        $commits = $commitService->getCommits('sample', 'samplerepo', $params);

        $this->assertEquals('9d42bb9baff767da49cc2c7697b6c78ced93f711', $commits[0]['id']);
        $this->assertCount(3, $commits);
    }

    public function testGetMergedBranchesFromBranch()
    {
        $jsonFile = __DIR__ . '/../assets/response/commits.json';
        $branchJsonFile = __DIR__ . '/../assets/response/branch.json';
        $branchService = new BranchesService($this->getClientMock($branchJsonFile));        
        $service = new CommitsService($this->getClientMock($jsonFile), $branchService);
        $branches = $service->getMergedBranchesFromBranch('develop', 'sample', 'samplerepo');

        $this->assertEquals(array('feature/test-feature'), $branches);
    }
}
