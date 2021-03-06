<?php

namespace StashApiBundle\Tests\Service;

use StashApiBundle\Tests\TestCase;
use StashApiBundle\Service\CommitService;

class CommitServiceTest extends TestCase
{
    public function testCommitServiceGetAll()
    {
        $jsonFile = __DIR__ . '/../assets/response/commits.json';

        $service = new CommitService($this->getClientMock($jsonFile));

        $params = array(
            'until' => 'refs/heads/develop'
        );

        $service->setStart(0);
        $service->setLimit(10000);

        $result = $service->getAll('PROJECT', 'repository', $params);

        $this->assertEquals(0, $service->getStart());
        $this->assertEquals(10000, $service->getLimit());

        $this->assertEquals('9d42bb9baff767da49cc2c7697b6c78ced93f711', $result['values'][0]['id']);
        $this->assertCount(3, $result['values']);
    }

    /**
     * @expectedException \Guzzle\Http\Exception\BadResponseException
     */
    public function testCommitServiceGetAllException()
    {
        $service = new CommitService($this->getClientMockException());

        $service->getAll('PROJECT', 'repository');
    }

    public function testCommitServiceGetAllNoData()
    {
        $service = new CommitService($this->getClientMockNoData());

        $result = $service->getAll('PROJECT', 'repository');

        $this->assertEquals(array(), $result['values']);
    }

    public function testCommitServiceGetAllErrors()
    {
        $service = new CommitService($this->getClientMockErrors());

        $result = $service->getAll('PROJECT', 'repository');

        $this->assertEquals(false, $result);
    }
}
