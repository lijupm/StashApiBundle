<?php

namespace StashApiBundle\Tests\Service;

use StashApiBundle\Tests\TestCase;
use StashApiBundle\Service\TagService;

class TagServiceTest extends TestCase
{
    public function testTagServiceGetAll()
    {
        $jsonFile = __DIR__ . '/../assets/response/tags.json';

        $service = new TagService(
            $this->getClientMock($jsonFile)
        );

        $service->setLimit(1000);
        $tags = $service->getAll('PROJECT', 'repository');

        $this->assertEquals(0, $service->getStart());
        $this->assertEquals(2, $service->getSize());
        $this->assertEquals(true, $service->isLastPage());

        $this->assertCount(2, $tags);
    }

    public function testTagServiceGetAllException()
    {
        $service = new TagService($this->getClientMockException());

        $result = $service->getAll('PROJECT', 'repository');

        $this->assertEquals(false, $result);
    }

    public function testTagServiceGetAllNoData()
    {
        $service = new TagService($this->getClientMockNoData());

        $result = $service->getAll('PROJECT', 'repository');

        $this->assertEquals(false, $result);
    }
}
