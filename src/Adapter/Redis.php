<?php

/**
 * This file is part of the Phalcon Incubator Annotations.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Incubator\Annotations\Adapter;

use Phalcon\Cache\Adapter\Redis as CacheRedis;
use Phalcon\Storage\SerializerFactory;
use Phalcon\Helper\Arr;

/**
 * Stores the parsed annotations to the Redis database.
 * This adapter is suitable for production.
 *
 *<code>
 * use Phalcon\Annotations\Adapter\Redis;
 *
 * $annotations = new Redis([
 *     'lifetime' => 8600,
 *     'host'     => 'localhost',
 *     'port'     => 6379,
 *     'prefix'   => 'annotations_',
 * ]);
 *</code>
 */
class Redis extends Cache
{
    /**
     * @param array $options Options array
     */
    public function __construct(array $options = [])
    {
        $options['cache'] = new CacheRedis(
            new SerializerFactory(),
            [
                'defaultSerializer' => 'php',
                'host' => Arr::get($options, 'host', '127.0.0.1'),
                'port' => Arr::get($options, 'port', 6379),
                'persistent' => Arr::get($options, 'persistent', false),
                'prefix' => Arr::get($options, 'prefix', 'annotations_'),
            ]
        );

        parent::__construct($options);
    }
}
