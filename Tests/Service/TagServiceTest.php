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

        $service->setStart(0);
        $service->setLimit(10000);

        $tags = $service->getAll('PROJECT', 'repository');

        $this->assertEquals(0, $service->getStart());
        $this->assertEquals(10000, $service->getLimit());

        $this->assertCount(2, $tags['values']);
    }

    /**
     * @expectedException \Guzzle\Http\Exception\BadResponseException
     */
    public function testTagServiceGetAllException()
    {
        $service = new TagService($this->getClientMockException());

        $service->getAll('PROJECT', 'repository');
    }

    public function testTagServiceGetAllNoData()
    {
        $service = new TagService($this->getClientMockNoData());

        $result = $service->getAll('PROJECT', 'repository');

        $this->assertEquals(array(), $result['values']);
    }

    public function testTagServiceGetAllErrors()
    {
        $service = new TagService($this->getClientMockErrors());

        $result = $service->getAll('PROJECT', 'repository');

        $this->assertEquals(false, $result);
    }
}
