<?php

namespace StashApiBundle\Service;

use Guzzle\Http\Client;

class CommitsService
{
    protected $client;
    protected $resultLimit = 25;

    /**
     * Constructor.
     *
     * @param Guzzle\Http\Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Set the maximum number of results being fetched from the REST api.
     *
     * @param integer $limit
     *
     * @return self
     */
    public function setResultLimit($limit)
    {
        $this->resultLimit = $limit;

        return $this;
    }

    /**
     * Creates and returns an stash compatible URL
     *
     * @param string $project
     * @param string $repository
     * @param array  $params
     *
     * @return string
     */
    protected function createUrl($project, $repository, array $params = array())
    {
        $url = sprintf('projects/%s/repos/%s/commits', $project, $repository);
        $params = array_merge($params, array('limit' => $this->resultLimit));

        $url = $url . '?' . http_build_query($params);

        return $url;
    }

    /**
     * Get a list of merged branches as an array based on 
     * Git normal merge commits.
     *
     * This means, if the commit message is heavily modified this method will
     * not include it into the list.
     *
     * @param string $baseBranch
     * @param string $project
     * @param string $repository
     *
     * @return null|array
     */
    public function getMergedBranchesFromBranch($baseBranch, $project, $repository)
    {
        $commits         = $this->getCommitsFromBranch($baseBranch, $project, $repository);
        $filteredCommits = array();

        if (null === $commits) {
            return null;
        }

        foreach ($commits as $commit) {
            if (preg_match('/^Merge .* from (.*) to .*/', $commit['message'], $matches)) {
                $filteredCommits[] = $matches[1];
            }
        }

        if (count($filteredCommits) == 0) {
            return null;
        }

        return $filteredCommits;
    }

    /**
     * Retrieve commits from a given branch name. And returns null when none found.
     *
     * @param string $branch
     * @param string $project
     * @param string $repository
     *
     * @return null|array
     */
    public function getCommitsFromBranch($branch, $project, $repository)
    {
        $url = $this->createUrl(
            $project,
            $repository,
            array(
                'until' => 'refs/heads/' . $branch
            )
        );

        $data = $this->getResponseAsArray($url);

        if (false === isset($data['values'])) {
            return null;
        }

        return $data['values'];
    }

    /**
     * Get response from Stash for the given API call.
     *
     * @param string $url
     *
     * @return array
     */
    private function getResponseAsArray($url)
    {
        $request = $this->client->get($url);
        $response = $request->send();

        return $response->json();
    }
}
