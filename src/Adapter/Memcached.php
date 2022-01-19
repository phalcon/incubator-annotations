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
use Phalcon\Support\Helper\Arr\Has;
use Phalcon\Support\Helper\Arr\Get;
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
        $this->getObject = new Get();
        $this->hasObject = new Has();

        if (!$this->hasObject->__invoke($options, 'host')) {
            throw new Exception('No host given in options');
        }

        $cache = new Libmemcached(
            new SerializerFactory(),
            [
                'defaultSerializer' => 'php',
                'lifetime'          => $this->getObject->__invoke($options, 'lifetime', 8600),
                'servers'           => [
                    [
                        'host'   => $this->getObject->__invoke($options, 'host', '127.0.0.1'),
                        'port'   => $this->getObject->__invoke($options, 'port', 11211),
                        'weight' => $this->getObject->__invoke($options, 'weight', 1),
                    ],
                ],
                'prefix' => $this->getObject->__invoke($options, 'prefix', 'annotations_'),
            ]
        );

        parent::__construct($cache, $options);
    }
}
