<?php

/**
 * This file is part of the Phalcon Migrations.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Phalcon\Incubator\Annotations\Adapter;

use Phalcon\Annotations\Exception;
use Phalcon\Cache\Frontend\Data as FrontendData;
use Phalcon\Cache\Backend\Aerospike as BackendAerospike;

/**
 * Class Aerospike
 *
 * Stores the parsed annotations to the Aerospike database.
 * This adapter is suitable for production.
 *
 *<code>
 * use Phalcon\Annotations\Adapter\Aerospike;
 *
 * $annotations = new Aerospike([
 *     'hosts' => [
 *         ['addr' => '127.0.0.1', 'port' => 3000]
 *     ],
 *     'persistent' => true,
 *     'namespace'  => 'test',
 *     'prefix'     => 'annotations_',
 *     'lifetime'   => 8600,
 *     'options'    => [
 *         \Aerospike::OPT_CONNECT_TIMEOUT => 1250,
 *         \Aerospike::OPT_WRITE_TIMEOUT   => 1500
 *     ]
 * ]);
 *</code>
 *
 * @package Phalcon\Annotations\Adapter
 */
class Aerospike extends Base
{
    /**
     * @var BackendAerospike
     */
    protected $aerospike;

    /**
     * Default Aerospike namespace
     * @var string
     */
    protected $namespace = 'test';

    /**
     * The Aerospike Set for store sessions
     * @var string
     */
    protected $set = 'annotations';

    /**
     * {@inheritdoc}
     *
     * @param array $options Options array
     * @throws Exception
     */
    public function __construct(array $options = [])
    {
        if (
            !isset($options['hosts']) ||
            !is_array($options['hosts']) ||
            !isset($options['hosts'][0]) ||
            !is_array($options['hosts'][0]) ||
            empty($options['hosts'][0])
        ) {
            throw new Exception('No hosts given in options');
        }

        if (isset($options['namespace'])) {
            $this->namespace = $options['namespace'];
        }

        if (isset($options['set']) && !empty($options['set'])) {
            $this->set = $options['set'];
        }

        if (!isset($options['persistent'])) {
            $options['persistent'] = false;
        }

        if (!isset($options['options']) || !is_array($options['options'])) {
            $options['options'] = [];
        }

        parent::__construct($options);

        $this->aerospike = new BackendAerospike(
            new FrontendData(
                [
                    'lifetime' => $this->options['lifetime'],
                ]
            ),
            [
                'hosts'      => $this->options['hosts'],
                'namespace'  => $this->namespace,
                'set'        => $this->set,
                'prefix'     => $this->options['lifetime'],
                'persistent' => (bool) $this->options['persistent'],
                'options'    => $this->options['options'],
            ]
        );
    }

    /**
     * {@inheritdoc}
     *
     * @return BackendAerospike
     */
    protected function getCacheBackend()
    {
        return $this->aerospike;
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
