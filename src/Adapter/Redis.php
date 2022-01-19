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
use Phalcon\Support\Helper\Arr\Get;
use Phalcon\Storage\SerializerFactory;

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
class Redis extends AbstractCache
{
    /**
     * @param array $options Options array
     */
    public function __construct(array $options = [])
    {
        $this->getObject =  new Get();
        $cache = new CacheRedis(
            new SerializerFactory(),
            [
                'defaultSerializer' => 'php',
                'host' => $this->getObject->__invoke($options, 'host', '127.0.0.1'),
                'port' => $this->getObject->__invoke($options, 'port', 6379),
                'persistent' => $this->getObject->__invoke($options, 'persistent', false),
                'prefix' => $this->getObject->__invoke($options, 'prefix', 'annotations_'),
            ]
        );

        parent::__construct($cache, $options);
    }
}
