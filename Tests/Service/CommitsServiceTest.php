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
        $params = array(
            'until' => 'refs/heads/develop'
        );
        $commits = $service->getCommits('develop', 'sample', $params);

        $this->assertEquals('9d42bb9baff767da49cc2c7697b6c78ced93f711', $commits[0]['id']);
        $this->assertCount(3, $commits);
    }

    public function testGetMergedBranches()
    {
        $jsonFile = __DIR__ . '/../assets/response/commits.json';

        $service = new CommitsService($this->getClientMock($jsonFile));
        $branches = $service->getMergedBranches('develop', 'sample', 'samplerepo');

        $this->assertEquals(array('feature/test-feature'), $branches);
    }
}
