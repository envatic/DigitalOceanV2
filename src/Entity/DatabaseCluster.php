<?php

/*
 * This file is part of the DigitalOceanV2 library.
 *
 * (c) Antoine Corcy <contact@sbin.dk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DigitalOceanV2\Entity;

/**
 * @author Maxime Renou <maxime@bluesquare.io>
 */
final class DatabaseCluster extends AbstractEntity
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $engine;

    /**
     * @var string
     */
    public $version;

    /**
     * @var string[]
     */
    public $dbNames;

    /**
     * @var int
     */
    public $num_nodes;

    /**
     * @var Region
     */
    public $region;

    /**
     * @var string
     */
    public $regionSlug;

    /**
     * @var Size
     */
    public $size;

    /**
     * @var string
     */
    public $sizeSlug;

    /**
     * @var string
     */
    public $status;

    /**
     * @var MaintenanceWindow
     */
    public $maintenanceWindow;

    /**
     * @var DatabaseConnection
     */
    public $connection;

    /**
     * @var DatabaseConnection
     */
    public $privateConnection;

    /**
     * @var DatabaseUser[]
     */
    public $users;

    /**
     * @var string
     */
    public $createdAt;

    /**
     * @var string[]
     */
    public $tags = [];

    /**
     * @param array $parameters
     */
    public function build(array $parameters)
    {
        foreach ($parameters as $property => $value) {
            switch ($property) {
                case 'region':
                    if (is_object($value)) {
                        $this->region = new Region($value);
                    }
                    else {
                        $this->region = new Region(['slug' => $value]);
                    }
                    unset($parameters[$property]);
                    break;

                case 'size':
                    if (is_object($value)) {
                        $this->size = new Size($value);
                    }
                    else {
                        $this->size = new Size(['slug' => $value]);
                    }
                    unset($parameters[$property]);
                    break;

                case 'maintenance_window':
                    if (is_object($value)) {
                        $this->maintenanceWindow = new MaintenanceWindow($value);
                    }
                    unset($parameters[$property]);
                    break;

                case 'connection':
                    if (is_object($value)) {
                        $this->connection = new DatabaseConnection($value);
                    }
                    unset($parameters[$property]);
                    break;

                case 'private_connection':
                    if (is_object($value)) {
                        $this->privateConnection = new DatabaseConnection($value);
                    }
                    unset($parameters[$property]);
                    break;

                case 'users':
                    if (is_array($value)) {
                        $this->users = [];
                        foreach ($value as $user) {
                            if (is_object($user)) {
                                $this->users[] = new DatabaseUser($user);
                            }
                        }
                    }
                    unset($parameters[$property]);
                    break;
            }
        }

        parent::build($parameters);
    }

    /**
     * @param string $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = static::convertDateTime($createdAt);
    }
}
