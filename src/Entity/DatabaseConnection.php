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
final class DatabaseConnection extends AbstractEntity
{
    /**
     * @var string
     */
    public $uri;

    /**
     * @var string
     */
    public $database;

    /**
     * @var string
     */
    public $host;

    /**
     * @var integer
     */
    public $port;

    /**
     * @var string
     */
    public $user;

    /**
     * @var string
     */
    public $password;

    /**
     * @var boolean
     */
    public $ssl;
}
