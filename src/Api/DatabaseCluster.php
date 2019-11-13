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

use DigitalOceanV2\Entity\Action as ActionEntity;
use DigitalOceanV2\Entity\DatabaseCluster as DatabaseClusterEntity;
use DigitalOceanV2\Exception\HttpException;

/**
 * @author Maxime Renou <maxime@bluesquare.io>
 */
class DatabaseCluster extends AbstractApi
{
    /**
     * @param string|null $tag
     *
     * @return DatabaseClusterEntity[]
     */
    public function getAll($tag = null)
    {
        $url = sprintf('%s/databases', $this->endpoint);

        if (null !== $tag) {
            $url .= '&tag_name='.$tag;
        }

        $databases = json_decode($this->adapter->get($url));

        $this->extractMeta($databases);

        return array_map(function ($database) {
            return new DatabaseClusterEntity($database);
        }, $databases->databases);
    }

    /**
     * @param int string
     *
     * @throws HttpException
     *
     * @return DatabaseClusterEntity
     */
    public function getById($id)
    {
        $database = $this->adapter->get(sprintf('%s/databases/%s', $this->endpoint, $id));

        $database = json_decode($database);

        return new DatabaseClusterEntity($database->database);
    }

    /**
     * @param string $name
     * @param string $region
     * @param string $size
     * @param string $engine
     * @param string $version
     * @param int $num_nodes
     * @param array $tags
     * @param bool $wait
     * @param int $waitTimeout
     *
     * @return DatabaseClusterEntity|null
     */
    public function create($name, $region, $size, $engine, $version = 'default', $num_nodes = 1, array $tags = [], $wait = false, $waitTimeout = 300)
    {
        $data = [
            'name' => $name,
            'region' => $region,
            'size' => $size,
            'engine' => $engine,
            'num_nodes' => $num_nodes
        ];

        if ($version != 'default') {
            $data['version'] = $version;
        }

        if (0 < count($tags)) {
            $data['tags'] = $tags;
        }

        $database = $this->adapter->post(sprintf('%s/databases', $this->endpoint), $data);

        $database = json_decode($database);

        $databaseEntity = new DatabaseClusterEntity($database->database);

        if ($wait) {
            return $this->waitForActive($databaseEntity, $waitTimeout);
        }

        return $databaseEntity;
    }

    /**
     * @param string    $id
     * @param string    $size
     * @param integer   $num_nodes
     *
     * @throws HttpException
     *
     * @return ActionEntity
     */
    public function resize($id, $size, $num_nodes = 1)
    {
        $data = ['type' => 'resize', 'size' => $size, 'num_nodes' => $num_nodes];

        $action = $this->adapter->put(sprintf('%s/databases/%s/resize', $this->endpoint, $id), $data);

        $action = json_decode($action);

        return $action;
    }

    /**
     * @param string $id
     * @param string $name
     * @return object
     * @throws HttpException
     */
    public function createDatabase($id, $name)
    {
        $action = $this->adapter->post(sprintf('%s/databases/%s/dbs', $this->endpoint, $id), ['name' => $name]);

        $action = json_decode($action);

        return $action;
    }

    /**
     * @param string $id
     * @param string $name
     * @return object
     * @throws HttpException
     */
    public function deleteDatabase($id, $name)
    {
        $action = $this->adapter->delete(sprintf('%s/databases/%s/dbs/%s', $this->endpoint, $id, urlencode($name)));

        $action = json_decode($action);

        return $action;
    }

    /**
     * @param string $id
     *
     * @throws HttpException
     */
    public function delete($id)
    {
        $this->adapter->delete(sprintf('%s/databases/%s', $this->endpoint, $id));
    }

    /**
     * @param DatabaseClusterEntity $database
     * @param int                   $waitTimeout
     *
     * @throws HttpException
     *
     * @return DatabaseClusterEntity|null
     */
    public function waitForActive($database, $waitTimeout)
    {
        $endTime = time() + $waitTimeout;

        while (time() < $endTime) {
            sleep(min(20, $endTime - time()));
            $database = $this->getById($database->id);
            if ($database->status === 'online') {
                return $database;
            }
        }

        return $database;
    }
}
