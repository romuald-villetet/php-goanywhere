<?php

namespace Alcohol\GoAnywhere\Api;

use Alcohol\GoAnywhere\Exception\HttpException;
use Alcohol\GoAnywhere\HttpClient\Message\ResponseMediator;

final class WebUsers extends HttpApi
{
    /**
     * Add a new web user.
     *
     * @param array $parameters
     *   An array representation of the expected JSON body
     *
     * @throws \Alcohol\GoAnywhere\Exception\HttpException
     */
    public function addUser(array $parameters)
    {
        $response = $this->post('/webusers', $parameters);

        if (400 <= $response->getStatusCode()) {
            throw new HttpException($response->getStatusCode(), $response->getBody()->__toString());
        }
    }

    /**
     * Update a web user.
     *
     * @param string $username
     *   The name of the user to update
     * @param array $parameters
     *   An array representation of the expected JSON body
     *
     * @throws \Alcohol\GoAnywhere\Exception\HttpException
     */
    public function updateUser($username, array $parameters)
    {
        $response = $this->put(sprintf('/webusers/%s/promote', urlencode($username)), $parameters);

        if (400 <= $response->getStatusCode()) {
            throw new HttpException($response->getStatusCode(), $response->getBody()->__toString());
        }
    }

    /**
     * Delete a web user.
     *
     * @param string $username
     *   The name of the user to delete
     *
     * @throws \Alcohol\GoAnywhere\Exception\HttpException
     */
    public function deleteUser($username)
    {
        $response = $this->delete(sprintf('/webusers/%s', urlencode($username)));

        if (400 <= $response->getStatusCode()) {
            throw new HttpException($response->getStatusCode(), $response->getBody()->__toString());
        }
    }

    /**
     * Export a web user as XML.
     *
     * @param string $username
     *   The name of the user to export
     *
     * @throws \Alcohol\GoAnywhere\Exception\HttpException
     *
     * @return string
     */
    public function exportUser($username)
    {
        $response = $this->get(sprintf('/webusers/%s', urlencode($username)));

        if (400 <= $response->getStatusCode()) {
            throw new HttpException($response->getStatusCode(), $response->getBody()->__toString());
        }

        return ResponseMediator::getContent($response);
    }

    /**
     * Import a web user.
     *
     * @param array $parameters
     *   An array representation of the expected JSON body
     *
     * @throws \Alcohol\GoAnywhere\Exception\HttpException
     */
    public function importUser(array $parameters)
    {
        $response = $this->post('/webusers', $parameters);

        if (400 <= $response->getStatusCode()) {
            throw new HttpException($response->getStatusCode(), $response->getBody()->__toString());
        }
    }

    /**
     * Promote a web user from one GoAnywhere server to another GoAnywhere server.
     *
     * @param string $username
     *   The name of the user to promote
     * @param array $parameters
     *   An array representation of the expected JSON body
     *
     * @throws \Alcohol\GoAnywhere\Exception\HttpException
     */
    public function promoteUser($username, array $parameters)
    {
        $response = $this->post(sprintf('/webusers/%s/promote', urlencode($username)), $parameters);

        if (400 <= $response->getStatusCode()) {
            throw new HttpException($response->getStatusCode(), $response->getBody()->__toString());
        }
    }

    /**
     * Reset a web user's password for GoAnywhere.
     *
     * @param string $username
     *   The name of the user
     * @param array $parameters
     *   An array representation of the expected JSON body
     *
     * @throws \Alcohol\GoAnywhere\Exception\HttpException
     */
    public function resetPassword($username, array $parameters)
    {
        $response = $this->post(sprintf('/webusers/%s/resetpassword', urlencode($username)), $parameters);

        if (400 <= $response->getStatusCode()) {
            throw new HttpException($response->getStatusCode(), $response->getBody()->__toString());
        }
    }

    /**
     * Associate a SSH key to a web user.
     *
     * @param string $username
     *   The name of the user
     * @param string $keyname
     *   The name of the SSH key
     *
     * @throws \Alcohol\GoAnywhere\Exception\HttpException
     */
    public function associateSshKey($username, $keyname)
    {
        $response = $this->post(sprintf('/webusers/%s/sshkeys/%s', urlencode($username), urlencode($keyname)));

        if (400 <= $response->getStatusCode()) {
            throw new HttpException($response->getStatusCode(), $response->getBody()->__toString());
        }
    }

    /**
     * Remove associated SSH key from web user.
     *
     * @param string $username
     *   The name of the user
     * @param string $keyname
     *   The name of the SSH key
     *
     * @throws \Alcohol\GoAnywhere\Exception\HttpException
     */
    public function disassociateSshKey($username, $keyname)
    {
        $response = $this->delete(sprintf('/webusers/%s/sshkeys/%s', urlencode($username), urlencode($keyname)));

        if (400 <= $response->getStatusCode()) {
            throw new HttpException($response->getStatusCode(), $response->getBody()->__toString());
        }
    }

    /**
     * Add a virtual file to a web user.
     *
     * @param string $username
     *   The name of the user
     * @param array $parameters
     *   An array representation of the expected JSON body
     *
     * @throws \Alcohol\GoAnywhere\Exception\HttpException
     */
    public function addVirtualFile($username, array $parameters)
    {
        $response = $this->post(sprintf('/webusers/%s/virtualfiles', urlencode($username)), $parameters);

        if (400 <= $response->getStatusCode()) {
            throw new HttpException($response->getStatusCode(), $response->getBody()->__toString());
        }
    }

    /**
     * Remove a virtual file from a web user.
     *
     * @param string $username
     *   The name of the user
     * @param string $filename
     *   The name of the virtual file
     *
     * @throws \Alcohol\GoAnywhere\Exception\HttpException
     */
    public function removeVirtualFile($username, $filename)
    {
        $response = $this->post(
            sprintf('/webusers/%s/virtualfiles', urlencode($username)),
            ['action' => 'remove', 'virtualPath' => $filename]
        );

        if (400 <= $response->getStatusCode()) {
            throw new HttpException($response->getStatusCode(), $response->getBody()->__toString());
        }
    }

    /**
     * Update a virtual file of a web user.
     *
     * @param string $username
     *   The name of the user
     * @param array $parameters
     *   An array representation of the expected JSON body
     *
     * @throws \Alcohol\GoAnywhere\Exception\HttpException
     */
    public function updateVirtualFile($username, array $parameters)
    {
        $response = $this->put(sprintf('/webusers/%s/virtualfiles', urlencode($username)), $parameters);

        if (400 <= $response->getStatusCode()) {
            throw new HttpException($response->getStatusCode(), $response->getBody()->__toString());
        }
    }

    /**
     * Add a virtual folder to a web user.
     *
     * @param string $username
     *   The name of the user
     * @param array $parameters
     *   An array representation of the expected JSON body
     *
     * @throws \Alcohol\GoAnywhere\Exception\HttpException
     */
    public function addVirtualFolder($username, array $parameters)
    {
        $response = $this->post(sprintf('/webusers/%s/virtualfolders', urlencode($username)), $parameters);

        if (400 <= $response->getStatusCode()) {
            throw new HttpException($response->getStatusCode(), $response->getBody()->__toString());
        }
    }

    /**
     * Remove a virtual folder from a web user.
     *
     * @param string $username
     *   The name of the user
     * @param string $folder
     *   The name of the virtual folder
     *
     * @throws \Alcohol\GoAnywhere\Exception\HttpException
     */
    public function removeVirtualFolder($username, $folder)
    {
        $response = $this->post(
            sprintf('/webusers/%s/virtualfolders', urlencode($username)),
            ['action' => 'remove', 'virtualPath' => $folder]
        );

        if (400 <= $response->getStatusCode()) {
            throw new HttpException($response->getStatusCode(), $response->getBody()->__toString());
        }
    }

    /**
     * Update a virtual folder of a web user.
     *
     * @param string $username
     *   The name of the user
     * @param array $parameters
     *   An array representation of the expected JSON body
     *
     * @throws \Alcohol\GoAnywhere\Exception\HttpException
     */
    public function updateVirtualFolder($username, array $parameters)
    {
        $response = $this->put(sprintf('/webusers/%s/virtualfolders', urlencode($username)), $parameters);

        if (400 <= $response->getStatusCode()) {
            throw new HttpException($response->getStatusCode(), $response->getBody()->__toString());
        }
    }
}
