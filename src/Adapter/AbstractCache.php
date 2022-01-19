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
use Phalcon\Annotations\Reflection;
use Phalcon\Cache\Adapter\AdapterInterface;
use Phalcon\Support\Helper\Arr\Get;
use Phalcon\Support\Helper\Arr\Has;

/**
 * Stores the parsed annotations to Cache (Use Phalcon\Cache\Adapter\AdapterInterface).
 * This adapter is suitable for production.
 *
 */
abstract class AbstractCache extends AbstractAdapter
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
     * @var Has
     */
    protected $hasObject;

    /**
     * @var Get
     */
    protected $getObject;

    /**
     * @param AdapterInterface $cache
     * @param array $options options array
     */
    public function __construct(AdapterInterface $cache, array $options = [])
    {
        $this->cache = $cache;
        $this->getObject = new Get();
        $this->hasObject = new Has();

        if ($this->hasObject->__invoke($options, 'lifetime')) {
            $this->lifetime = $this->getObject->__invoke($options, 'lifetime');
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
