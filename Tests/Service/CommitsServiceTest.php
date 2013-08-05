<?php

namespace StashApiBundle\Tests\Service;

use StashApiBundle\Tests\TestCase;
use StashApiBundle\Service\CommitsService;

class CommitsServiceTest extends TestCase
{
    public function testGetCommitsFromBranch()
    {
        $jsonFile = __DIR__ . '/../assets/response/commits.json';

        $service = new CommitsService($this->getClientMock($jsonFile));
        $commits = $service->getCommitsFromBranch('develop', 'sample', 'samplerepo');

        $this->assertEquals('9d42bb9baff767da49cc2c7697b6c78ced93f711', $commits[0]['id']);
        $this->assertCount(3, $commits);
    }

    public function testGetMergedBranchesFromBranch()
    {
        $jsonFile = __DIR__ . '/../assets/response/commits.json';

        $service = new CommitsService($this->getClientMock($jsonFile));
        $branches = $service->getMergedBranchesFromBranch('develop', 'sample', 'samplerepo');

        $this->assertEquals(array('feature/test-feature'), $branches);
    }
}
