<?php

/**
 * This file is part of the Phalcon Migrations.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Phalcon\Annotations\Adapter;

use Phalcon\Cache\Backend\Redis as BackendRedis;
use Phalcon\Cache\Frontend\Data as FrontendData;

/**
 * Class Redis
 *
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
 *
 * @package Phalcon\Annotations\Adapter
 */
class Redis extends Base
{
    /**
     * @var BackendRedis
     */
    protected $redis;

    /**
     * {@inheritdoc}
     *
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

        $this->redis = new BackendRedis(
            new FrontendData(
                [
                    'lifetime' => $this->options['lifetime'],
                ]
            ),
            $options
        );
    }

    /**
     * {@inheritdoc}
     *
     * @return BackendRedis
     */
    protected function getCacheBackend()
    {
        return $this->redis;
    }

    /**
     * {@inheritdoc}
     *
     * @param string $key
     * @return string
     */
    protected function prepareKey($key)
    {
        return strval($key);
    }
}
