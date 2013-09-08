<?php

namespace StashApiBundle\Tests\Service;

use StashApiBundle\Tests\TestCase;
use StashApiBundle\Service\PullRequestService;

class PullRequestServiceTest extends TestCase
{
    public function testPullRequestServiceGetAll()
    {
        $jsonFile = __DIR__ . '/../assets/response/pull-requests.json';

        $service = new PullRequestService($this->getClientMock($jsonFile));

        $service->setStart(0);
        $service->setLimit(10000);

        $pullRequests = $service->getAll('PROJECT', 'repository');

        $this->assertEquals(0, $service->getStart());
        $this->assertEquals(10000, $service->getLimit());

        $this->assertCount(17, $pullRequests['values']);
    }

    /**
     * @expectedException \Guzzle\Http\Exception\BadResponseException
     */
    public function testPullRequestServiceGetAllException()
    {
        $service = new PullRequestService($this->getClientMockException());

        $service->getAll('PROJECT', 'repository');
    }

    public function testPullRequestServiceGetAllNoData()
    {
        $service = new PullRequestService($this->getClientMockNoData());

        $result = $service->getAll('PROJECT', 'repository');

        $this->assertEquals(array(), $result['values']);
    }

    public function testPullRequestServiceGetAllErrors()
    {
        $service = new PullRequestService($this->getClientMockErrors());

        $result = $service->getAll('PROJECT', 'repository');

        $this->assertEquals(false, $result);
    }
}
