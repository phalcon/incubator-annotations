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
use Phalcon\Annotations\Exception;
use Phalcon\Annotations\Reflection;
use Phalcon\Cache\Adapter\AdapterInterface;
use Phalcon\Helper\Arr;

/**
 * Stores the parsed annotations to Cache (Use Phalcon\Cache\Adapter\AdapterInterface).
 * This adapter is suitable for production.
 *
 */
class Cache extends AbstractAdapter
{
    /**
     * @var AdapterInterface
     */
    protected $cache;

    /**
     * @var int
     */
    protected $lifetime = 8600;

    /**
     * {@inheritdoc}
     *
     * @param array $options options array
     *
     * @throws Exception
     */
    public function __construct(array $options)
    {
        if (!Arr::has($options, 'cache') || !Arr::get($options, 'cache') instanceof AdapterInterface) {
            throw new Exception(
                'Parameter "cache" is required and it must be an instance of Phalcon\Cache\Adapter\AdapterInterface'
            );
        }

        $this->cache = Arr::get($options, 'cache');

        if (Arr::has($options, 'lifetime')) {
            $this->lifetime = Arr::get($options, 'lifetime');
        }
    }

    public function read(string $key): ?Reflection
    {
        return $this->cache->get($this->prepareKey($key));
    }

    public function write(string $key, Reflection $data): bool
    {
        return $this->cache->set(
            $this->prepareKey($key),
            $data,
            $this->lifetime
        );
    }

    public function prepareKey(string $key): string
    {
        return $key;
    }
}
