StashApiBundle
==============

Master: [![Build Status](https://secure.travis-ci.org/MedicoreNL/StashApiBundle.png?branch=master)](http://travis-ci.org/MedicoreNL/StashApiBundle)

A [Symfony2](http://symfony.com) bundle that integrates the [Stash](https://www.atlassian.com/software/stash/overview) [REST API](https://developer.atlassian.com/stash/docs/latest/reference/rest-api.html) into native Symfony2 services.

Installation
------------

 1. Install [Composer](https://getcomposer.org).

    ```bash
    # Install Composer
    curl -sS https://getcomposer.org/installer | php
    ```

 2. Add this bundle to the `composer.json` file of your project.

    ```bash
    # Add StashApiBundle as a dependency
    php composer.phar require medicorenl/stash-api-bundle dev-master
    ```
 3. After installing, you need to require Composer's autloader in the bootstrap of your project.

    ```php
    // app/autoload.php
    $loader = require __DIR__ . '/../vendor/autoload.php';
    ```

 4. Add the bundle to your application kernel.

    ```php
    // app/AppKernel.php
    public function registerBundles()
    {
        return array(
            // ...
            new StashApiBundle\StashApiBundle(),
            // ...
        );
    }
    ```

 5. Configure the bundle by adding parameters to the  `config.yml` file:

    ```yaml
    # app/config/config.yml
        stash_api.url:         "http://stash.your-organisation.com/rest/api/latest/"
        stash_api.credentials: "username:password"
    ```

Usage
-----

This bundle contains a number of services, to access them through the service container:

```php
// Get the StashApiBundle\Service\BranchService
$branchService = $this->get('stash_api.branch');
$branchService->searchBranch($project, $repository, $branch);

// Get the StashApiBundle\Service\TagService
$tagService = $this->get('stash_api.tag');
$tagService->getAll($project, $repository, $params);

// Get the StashApiBundle\Service\CommitService
$commitService = $this->get('stash_api.commit');
$commitService->getAll($project, $repository, $params);

// Get the StashApiBundle\Service\FileService
$fileService = $this->get('stash_api.file');
$fileService->getAll($project, $repository, $reference, $path);

// Get the StashApiBundle\Service\PullRequestService
$pullRequestService = $this->get('stash_api.pullrequest');
$pullRequestService->getAll($project, $repository, $params);
```

You can also add them to the service container of your own bundle:

```xml
<!-- src/Project/Bundle/Resources/config/services.xml -->
<?xml version="1.0" encoding="UTF-8"?>
<container xmlns="http://symfony.com/schema/dic/services"
           xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
           xsi:schemaLocation="http://symfony.com/schema/dic/services http://symfony.com/schema/dic/services/services$
    <services>
        <service id="myproject.myservice" class="MyProject\MyBundle\Services\MyService.php" public="true">
            <argument type="service" id="stash_api.commit" />
            <argument type="service" id="stash_api.file" />
            <argument type="service" id="stash_api.branch" />
            <argument type="service" id="stash_api.tag" />
            <argument type="service" id="stash_api.pullrequest" />
        </service>
    </services>
</container>
```

You can then use them in your own services

```php
<?php

namespace Project\Bundle\Services;

use StashApiBundle\Service\CommitService;
use StashApiBundle\Service\FileService;
use StashApiBundle\Service\BranchService;
use StashApiBundle\Service\TagService;
use StashApiBundle\Service\PullRequestService;

/**
 * Service class for my bundle.
 */
class MyService
{
    /**
     * @var \StashApiBundle\Service\CommitService
     */
    private $commitService;

    /**
     * @var \StashApiBundle\Service\FileService
     */
    private $fileService;

    /**
     * @var \StashApiBundle\Service\BranchService
     */
    private $branchService;

    /**
     * @var \StashApiBundle\Service\TagService
     */
    private $tagService;

    /**
     * @var \StashApiBundle\Service\PullRequestService
     */
    private $pullRequestService;

    /**
     * Constructor.
     *
     * @param \StashApiBundle\Service\CommitService      $commitService
     * @param \StashApiBundle\Service\FileService        $fileService
     * @param \StashApiBundle\Service\BranchServie       $branchService
     * @param \StashApiBundle\Service\TagService         $tagService
     * @param \StashApiBundle\Service\PullRequestService $pullRequestService
     */
    public function __construct(
        CommitService      $commitService,
        FileService        $fileService,
        BranchService      $branchService,
        TagService         $tagService,
        PullRequestService $pullRequestService,
    ) {
        $this->commitService      = $commitService;
        $this->fileService        = $fileService;
        $this->branchService      = $branchService;
        $this->tagService         = $tagService;
        $this->pullRequestService = $pullRequestService;
    }
}
```

Unit testing
------------

StashApiBundle uses [PHP Unit](http://phpunit.de) for unit testing.

 1. Download PHP Unit.

    ```bash
    # Download PHP Unit
    wget http://pear.phpunit.de/get/phpunit.phar
    chmod +x phpunit.phar
    ```

 2. Make sure all dependencies are installed through Composer.

    ```bash
    # Install dependencies
    php composer.phar install
    ```

 3. Run the unit tests.

    ```bash
    # Run unit tests
    php phpunit.phar
    ```
