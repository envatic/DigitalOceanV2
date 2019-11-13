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
final class MaintenanceWindow extends AbstractEntity
{
    /**
     * @var string
     */
    public $day;

    /**
     * @var string
     */
    public $hour;

    /**
     * @var string[]
     */
    public $description;

    /**
     * @var boolean
     */
    public $pending;
}
