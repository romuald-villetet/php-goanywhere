<?php

namespace Alcohol\GoAnywhere\Api;

use Alcohol\GoAnywhere\Exception\HttpException;
use Alcohol\GoAnywhere\HttpClient\Message\ResponseMediator;

final class WebGroups extends HttpApi
{
    /**
     * Delete a web user group.
     *
     * @param string $group
     *   The name of the group to delete
     *
     * @throws \Alcohol\GoAnywhere\Exception\HttpException
     */
    public function deleteGroup($group)
    {
        $response = $this->delete(sprintf('/webgroups/%s', urlencode($group)));

        if (400 <= $response->getStatusCode()) {
            throw new HttpException($response->getStatusCode(), $response->getBody()->getContents());
        }
    }

    /**
     * Export a web user group as XML.
     *
     * @param string $group
     *   The name of the group to export
     *
     * @throws \Alcohol\GoAnywhere\Exception\HttpException
     *
     * @return string
     */
    public function exportGroup($group)
    {
        $response = $this->get(sprintf('/webgroups/%s', urlencode($group)));

        if (400 <= $response->getStatusCode()) {
            throw new HttpException($response->getStatusCode(), $response->getBody()->getContents());
        }

        return ResponseMediator::getContent($response);
    }

    /**
     * Import a web user group.
     *
     * @param array $parameters
     *   An array representation of the expected JSON body
     *
     * @throws \Alcohol\GoAnywhere\Exception\HttpException
     */
    public function importGroup(array $parameters)
    {
        $response = $this->post('/webgroups', $parameters);

        if (400 <= $response->getStatusCode()) {
            throw new HttpException($response->getStatusCode(), $response->getBody()->getContents());
        }
    }

    /**
     * Promote a web user group from one GoAnywhere server to another GoAnywhere server.
     *
     * @param string $group
     *   The name of the group to promote
     * @param array $parameters
     *   An array representation of the expected JSON body
     *
     * @throws \Alcohol\GoAnywhere\Exception\HttpException
     */
    public function promoteGroup($group, array $parameters)
    {
        $response = $this->post(sprintf('/webgroups/%s/promote', urlencode($group)), $parameters);

        if (400 <= $response->getStatusCode()) {
            throw new HttpException($response->getStatusCode(), $response->getBody()->getContents());
        }
    }

    /**
     * Add a virtual file to a web user group.
     *
     * @param string $group
     *   The name of the group
     * @param array $parameters
     *   An array representation of the expected JSON body
     *
     * @throws \Alcohol\GoAnywhere\Exception\HttpException
     */
    public function addVirtualFile($group, array $parameters)
    {
        $response = $this->post(sprintf('/webgroups/%s/virtualfiles', urlencode($group)), $parameters);

        if (400 <= $response->getStatusCode()) {
            throw new HttpException($response->getStatusCode(), $response->getBody()->getContents());
        }
    }

    /**
     * Remove a virtual file from a web user group.
     *
     * @param string $group
     *   The name of the group
     * @param string $filename
     *   The name of the virtual file
     *
     * @throws \Alcohol\GoAnywhere\Exception\HttpException
     */
    public function removeVirtualFile($group, $filename)
    {
        $response = $this->post(
            sprintf('/webgroups/%s/virtualfiles', urlencode($group)),
            ['action' => 'remove', 'virtualPath' => $filename]
        );

        if (400 <= $response->getStatusCode()) {
            throw new HttpException($response->getStatusCode(), $response->getBody()->getContents());
        }
    }

    /**
     * Update a virtual file of a web user group.
     *
     * @param string $group
     *   The name of the group
     * @param array $parameters
     *   An array representation of the expected JSON body
     *
     * @throws \Alcohol\GoAnywhere\Exception\HttpException
     */
    public function updateVirtualFile($group, array $parameters)
    {
        $response = $this->put(sprintf('/webgroups/%s/virtualfiles', urlencode($group)), $parameters);

        if (400 <= $response->getStatusCode()) {
            throw new HttpException($response->getStatusCode(), $response->getBody()->getContents());
        }
    }

    /**
     * Add a virtual folder to a web user group.
     *
     * @param string $group
     *   The name of the group
     * @param array $parameters
     *   An array representation of the expected JSON body
     *
     * @throws \Alcohol\GoAnywhere\Exception\HttpException
     */
    public function addVirtualFolder($group, array $parameters)
    {
        $response = $this->post(sprintf('/webgroups/%s/virtualfolders', urlencode($group)), $parameters);

        if (400 <= $response->getStatusCode()) {
            throw new HttpException($response->getStatusCode(), $response->getBody()->getContents());
        }
    }

    /**
     * Remove a virtual folder from a web user group.
     *
     * @param string $group
     *   The name of the group
     * @param string $folder
     *   The name of the virtual folder
     *
     * @throws \Alcohol\GoAnywhere\Exception\HttpException
     */
    public function removeVirtualFolder($group, $folder)
    {
        $response = $this->post(
            sprintf('/webgroups/%s/virtualfolders', urlencode($group)),
            ['action' => 'remove', 'virtualPath' => $folder]
        );

        if (400 <= $response->getStatusCode()) {
            throw new HttpException($response->getStatusCode(), $response->getBody()->__toString());
        }
    }

    /**
     * Update a virtual folder of a web user group.
     *
     * @param string $group
     *   The name of the group
     * @param array $parameters
     *   An array representation of the expected JSON body
     *
     * @throws \Alcohol\GoAnywhere\Exception\HttpException
     */
    public function updateVirtualFolder($group, array $parameters)
    {
        $response = $this->put(sprintf('/webgroups/%s/virtualfolders', urlencode($group)), $parameters);

        if (400 <= $response->getStatusCode()) {
            throw new HttpException($response->getStatusCode(), $response->getBody()->__toString());
        }
    }
}
