<?php

namespace StashApiBundle\Tests\Service;

use StashApiBundle\Tests\TestCase;
use StashApiBundle\Service\CommitService;

class CommitServiceTest extends TestCase
{
    public function testCommitServiceGetAll()
    {
        $jsonFile = __DIR__ . '/../assets/response/commits.json';

        $service = new CommitService(
            $this
                ->getClientMock($jsonFile)
        );

        $params = array(
            'until' => 'refs/heads/develop'
        );
        $commits = $service->getAll('PROJECT', 'repo', $params);

        $this->assertEquals('9d42bb9baff767da49cc2c7697b6c78ced93f711', $commits[0]['id']);
        $this->assertCount(3, $commits);
    }
}
