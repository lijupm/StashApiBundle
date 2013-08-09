<?php

namespace StashApiBundle\Tests\Service;

use StashApiBundle\Tests\TestCase;
use StashApiBundle\Service\PullRequestService;
use StashApiBundle\Tests\JsonResponseMock;

class PullRequestServiceTest extends TestCase
{
    public function testGetAll()
    {
        $jsonFile = __DIR__ . '/../assets/response/pull-requests.json';

        $service = new PullRequestService($this->getClientMock($jsonFile));
        $pullRequests = $service->getAll('mcis', 'mcis');

        $this->assertCount(17, $pullRequests);
    }

    public function testGetAllOptions()
    {
        $jsonFile = __DIR__ . '/../assets/response/pull-requests-with-options.json';

        $service = new PullRequestService($this->getClientMock($jsonFile));
        $pullRequests = $service->getAll(
            'mcis',
            'mcis',
            array(
                'direction' => 'incoming',
                'state' => 'merged',
                'order' => 'newest'
            )
        );

        $this->assertCount(17, $pullRequests);
    }
}
