<?php

namespace StashApiBundle\Tests\Service;

use StashApiBundle\Tests\TestCase;
use StashApiBundle\Service\PullRequestService;

class PullRequestServiceTest extends TestCase
{
    public function testPullRequestServiceGetAll()
    {
        $jsonFile = __DIR__ . '/../assets/response/pull-requests.json';

        $service = new PullRequestService(
            $this->getClientMock(
                $jsonFile
            )
        );

        $service->setLimit(1000);
        $pullRequests = $service->getAll('PROJECT', 'repository');

        $this->assertEquals(0, $service->getStart());
        $this->assertEquals(17, $service->getSize());
        $this->assertEquals(true, $service->isLastPage());

        $this->assertCount(17, $pullRequests);
    }

    public function testPullRequestServiceGetAllException()
    {
        $service = new PullRequestService($this->getClientExceptionMock());

        $result = $service->getAll('PROJECT', 'repository');

        $this->assertEquals(false, $result);
    }

    public function testPullRequestServiceGetAllNoData()
    {
        $service = new PullRequestService($this->getClientNoDataMock());

        $result = $service->getAll('PROJECT', 'repository');

        $this->assertEquals(false, $result);
    }
}
