<?php

namespace StashApiBundle\Tests\Service;

use StashApiBundle\Tests\TestCase;
use StashApiBundle\Service\FileService;

class FileServiceTest extends TestCase
{
    public function testFileServiceGetAll()
    {
        $jsonFile = __DIR__ . '/../assets/response/files.json';

        $service = new FileService(
            $this->getClientMock(
                $jsonFile
            )
        );

        $service->setLimit(1000);
        $files = $service->getAll('PROJECT', 'repository', 'path');

        $this->assertEquals(1000, $service->getStart());
        $this->assertEquals(25, $service->getSize());
        $this->assertEquals(false, $service->isLastPage());

        $this->assertCount(22, $files);
    }

    public function testFileServiceGetAllException()
    {
        $service = new FileService($this->getClientExceptionMock());

        $result = $service->getAll('PROJECT', 'repository', 'path');

        $this->assertEquals(false, $result);
    }

    public function testFileServiceGetAllNoData()
    {
        $service = new FileService($this->getClientNoDataMock());

        $result = $service->getAll('PROJECT', 'repository', 'path');

        $this->assertEquals(false, $result);
    }
}
