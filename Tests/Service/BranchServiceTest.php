<?php

namespace StashApiBundle\Tests\Service;

use StashApiBundle\Tests\TestCase;
use StashApiBundle\Service\BranchService;

class BranchServiceTest extends TestCase
{
    public function testBranchServiceSearch()
    {
        $jsonFile = __DIR__ . '/../assets/response/branch.json';

        $service = new BranchService($this->getClientMock($jsonFile));

        $result = $service->search('PROJECT', 'repository', 'branch');

        $this->assertCount(2, $result['values']);
    }

    /**
     * @expectedException \Guzzle\Http\Exception\BadResponseException
     */
    public function testBranchServiceSearchException()
    {
        $service = new BranchService($this->getClientMockException());

        $service->search('PROJECT', 'repository', 'branch');
    }

    public function testBranchServiceSearchNoData()
    {
        $service = new BranchService($this->getClientMockNoData());

        $result = $service->search('PROJECT', 'repository', 'branch');

        $this->assertEquals(array(), $result['values']);
    }

    public function testBranchServiceSearchErrors()
    {
        $service = new BranchService($this->getClientMockErrors());

        $result = $service->search('PROJECT', 'repository', 'branch');

        $this->assertEquals(false, $result);
    }
}
