<?php

namespace StashApiBundle\Tests\Service;

use StashApiBundle\Tests\TestCase;
use StashApiBundle\Service\FilesService;

class FilesServiceTest extends TestCase
{
    public function testGetCommitsFromBranch()
    {
        $fileJsonFile = __DIR__ . '/../assets/response/file.json';
        $fileService = new FilesService($this->getClientMock($fileJsonFile));
        $files = $fileService->getFilesFromBranch('sample', 'samplerepo', 'develop');

        $this->assertEquals('Version20130513105519.php', $files[1]);
        $this->assertCount(2, $files);
    }
}
