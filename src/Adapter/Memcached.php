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

use Phalcon\Annotations\Exception;
use Phalcon\Cache\Adapter\Libmemcached;
use Phalcon\Helper\Arr;
use Phalcon\Storage\SerializerFactory;

/**
 * Stores the parsed annotations to Memcached.
 * This adapter is suitable for production.
 *
 *<code>
 * use Phalcon\Annotations\Adapter\Memcached;
 *
 * $annotations = new Memcached([
 *     'lifetime' => 8600,
 *     'host'     => 'localhost',
 *     'port'     => 11211,
 *     'weight'   => 1,
 *     'prefix'   => 'annotations_.',
 * ]);
 *</code>
 */
class Memcached extends AbstractCache
{
    /**
     * @param array $options options array
     *
     * @throws Exception
     */
    public function __construct(array $options)
    {
        if (!Arr::has($options, 'host')) {
            throw new Exception('No host given in options');
        }

        $cache = new Libmemcached(
            new SerializerFactory(),
            [
                'defaultSerializer' => 'php',
                'lifetime'          => Arr::get($options, 'lifetime', 8600),
                'servers'           => [
                    [
                        'host'   => Arr::get($options, 'host', '127.0.0.1'),
                        'port'   => Arr::get($options, 'port', 11211),
                        'weight' => Arr::get($options, 'weight', 1),
                    ],
                ],
                'prefix' => Arr::get($options, 'prefix', 'annotations_'),
            ]
        );

        parent::__construct($cache, $options);
    }
}
