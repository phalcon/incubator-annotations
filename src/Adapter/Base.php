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

use Phalcon\Annotations\Adapter;

/**
 * \Phalcon\Annotations\Adapter\Base
 *
 * Base class for annotations adapters.
 *
 * @package Phalcon\Annotations\Adapter
 */
abstract class Base extends Adapter
{
    /**
     * Default option for cache lifetime.
     *
     * @var array
     */
    protected static $defaultLifetime = 8600;

    /**
     * Default option for prefix.
     *
     * @var string
     */
    protected static $defaultPrefix = '';

    /**
     * Backend's options.
     *
     * @var array
     */
    protected $options = null;

    /**
     * Class constructor.
     *
     * @param null|array $options
     *
     * @throws \Phalcon\Mvc\Model\Exception
     */
    public function __construct($options = null)
    {
        if (!is_array($options) || !isset($options['lifetime'])) {
            $options['lifetime'] = self::$defaultLifetime;
        }

        if (!is_array($options) || !isset($options['prefix'])) {
            $options['prefix'] = self::$defaultPrefix;
        }

        $this->options = $options;
    }

    /**
     * {@inheritdoc}
     *
     * @param string $key
     *
     * @return array
     */
    public function read($key)
    {
        $backend = $this->getCacheBackend();

        return $backend->get(
            $this->prepareKey($key),
            $this->options['lifetime']
        );
    }

    /**
     * {@inheritdoc}
     *
     * @param string $key
     * @param array $data
     */
    public function write($key, $data)
    {
        $backend = $this->getCacheBackend();

        $backend->save(
            $this->prepareKey($key),
            $data,
            $this->options['lifetime']
        );
    }

    /**
     * Returns the key with a prefix or other changes
     *
     * @param string $key
     *
     * @return string
     */
    abstract protected function prepareKey($key);

    /**
     * Returns cache backend instance.
     *
     * @return \Phalcon\Cache\BackendInterface
     */
    abstract protected function getCacheBackend();
}
