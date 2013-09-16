<?php

namespace StashApiBundle\Tests\Service;

use StashApiBundle\Tests\TestCase;
use StashApiBundle\Service\FileService;

class FileServiceTest extends TestCase
{
    public function testFileServiceGetAll()
    {
        $jsonFile = __DIR__ . '/../assets/response/files.json';

        $service = new FileService($this->getClientMock($jsonFile));

        $service->setStart(0);
        $service->setLimit(10000);

        $files = $service->getAll('PROJECT', 'repository', 'path');

        $this->assertEquals(0, $service->getStart());
        $this->assertEquals(10000, $service->getLimit());

        $this->assertCount(22, $files['values']);
    }

    /**
     * @expectedException \Guzzle\Http\Exception\BadResponseException
     */
    public function testFileServiceGetAllException()
    {
        $service = new FileService($this->getClientMockException());

        $service->getAll('PROJECT', 'repository', 'path');
    }

    public function testFileServiceGetAllNoData()
    {
        $service = new FileService($this->getClientMockNoData());

        $result = $service->getAll('PROJECT', 'repository', 'path');

        $this->assertEquals(array(), $result['values']);
    }

    public function testFileServiceGetAllErrors()
    {
        $service = new FileService($this->getClientMockErrors());

        $result = $service->getAll('PROJECT', 'repository', 'path');

        $this->assertEquals(false, $result);
    }
}
