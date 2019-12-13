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
final class DatabaseReplica extends AbstractEntity
{

    /**
     * @var string
     */
    public $name;
    /**
     * @var Region
     */
    public $region;

    /**
     * @var DatabaseConnection
     */
    public $connection;

    /**
     * @var DatabaseConnection
     */
    public $privateConnection;

    /**
     * @var string
     */
    public $status;

    /**
     * @var string
     */
    public $createdAt;

   
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
