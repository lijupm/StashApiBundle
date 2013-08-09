<?php

namespace StashApiBundle\Tests\Service;

use StashApiBundle\Tests\TestCase;
use StashApiBundle\Service\FilesService;

class FilesServiceTest extends TestCase
{
    public function testGetAll()
    {
        $jsonFile = __DIR__ . '/../assets/response/files.json';

        $service = new FilesService($this->getClientMock($jsonFile));
        $files = $service->getFilesFromBranch('mcis', 'mcis', 'develop');

        $this->assertCount(22, $files);
    }

    public function testGetAllFiltered()
    {
        $jsonFile = __DIR__ . '/../assets/response/files-with-path.json';

        $service = new FilesService($this->getClientMock($jsonFile));
        $files = $service->getFilesFromBranch('mcis', 'mcis', 'develop', 'mcis');

        $this->assertCount(22, $files);
    }
}
