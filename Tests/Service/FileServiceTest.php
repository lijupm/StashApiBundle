<?php

namespace StashApiBundle\Tests\Service;

use StashApiBundle\Tests\TestCase;
use StashApiBundle\Service\FileService;

class FileServiceTest extends TestCase
{
    public function testGetAll()
    {
        $jsonFile = __DIR__ . '/../assets/response/files.json';

        $service = new FileService(
            $this
                ->getClientMock(
                    $jsonFile
                )
        );

        $files = $service->getAll('PROJECT', 'repo', 'branch');

        $this->assertCount(22, $files);
    }

    public function testGetAllFiltered()
    {
        $jsonFile = __DIR__ . '/../assets/response/files-with-path.json';

        $service = new FileService(
            $this
                ->getClientMock(
                    $jsonFile
                )
        );

        $files = $service->getAll('PROJECT', 'repo', 'branch', 'file');

        $this->assertCount(22, $files);
    }
}
