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

use Phalcon\Annotations\Adapter\AbstractAdapter;
use Phalcon\Cache\Adapter\Redis as CacheRedis;
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
class Redis extends AbstractAdapter
{
    /**
     * @var CacheRedis
     */
    protected $redis;

    /**
     * @param array $options Options array
     */
    public function __construct(array $options = [])
    {
        if (!isset($options['host'])) {
            $options['host'] = '127.0.0.1';
        }

        if (!isset($options['port'])) {
            $options['port'] = 6379;
        }

        if (!isset($options['persistent'])) {
            $options['persistent'] = false;
        }

        parent::__construct($options);

        $this->redis = new CacheRedis(new SerializerFactory(), $options);
    }
}
