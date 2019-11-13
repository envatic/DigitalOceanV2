<?php

/*
 * This file is part of the DigitalOceanV2 library.
 *
 * (c) Antoine Corcy <contact@sbin.dk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DigitalOceanV2\Api;

use DigitalOceanV2\Exception\HttpException;

/**
 * @author Maxime Renou <maxime@bluesquare.io>
 */
class Request extends AbstractApi
{
    /**
     * @param string $uri
     * @return string
     * @throws HttpException
     */
    public function get($uri)
    {
        return $this->adapter->get(sprintf('%s/%s', $this->endpoint, $uri));
    }

    /**
     * @param string $uri
     * @param mixed $content
     * @return string
     * @throws HttpException
     */
    public function put($uri, $content = '')
    {
        $this->adapter->put(sprintf('%s/%s', $this->endpoint, $uri), $content);
    }

    /**
     * @param string $uri
     * @param mixed $content
     * @return string
     * @throws HttpException
     */
    public function post($uri, $content = '')
    {
        $this->adapter->post(sprintf('%s/%s', $this->endpoint, $uri), $content);
    }

    /**
     * @param string $uri
     * @param mixed $content
     * @return string
     * @throws HttpException
     */
    public function delete($uri, $content = '')
    {
        return $this->adapter->delete(sprintf('%s/%s', $this->endpoint, $uri), $content);
    }
}
