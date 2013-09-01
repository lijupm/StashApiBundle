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
            $this->getClientMock($jsonFile)
        );

        $params = array(
            'until' => 'refs/heads/develop'
        );

        $service->setLimit(1000);
        $commits = $service->getAll('PROJECT', 'repository', $params);

        $this->assertEquals(0, $service->getStart());
        $this->assertEquals(3, $service->getSize());
        $this->assertEquals(true, $service->isLastPage());

        $this->assertEquals('9d42bb9baff767da49cc2c7697b6c78ced93f711', $commits[0]['id']);
        $this->assertCount(3, $commits);
    }

    public function testCommitServiceGetAllException()
    {
        $service = new CommitService($this->getClientMockException());

        $result = $service->getAll('PROJECT', 'repository');

        $this->assertEquals(false, $result);
    }

    public function testCommitServiceGetAllNoData()
    {
        $service = new CommitService($this->getClientMockNoData());

        $result = $service->getAll('PROJECT', 'repository');

        $this->assertEquals(false, $result);
    }
}
