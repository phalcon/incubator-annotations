<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Incubator\Annotations\Tests\Unit\Adapter\Cache;

use Phalcon\Annotations\Adapter\AdapterInterface;
use Phalcon\Annotations\Exception;
use Phalcon\Cache\Adapter\Memory;
use Phalcon\Incubator\Annotations\Adapter\Cache;
use Phalcon\Storage\SerializerFactory;
use UnitTester;

class ConstructCest
{
    /**
     * Tests Phalcon\Incubator\Annotations\Adapter\Cache :: __construct()
     *
     */
    public function annotationsAdapterMemcachedConstruct(UnitTester $I)
    {
        $I->wantToTest('Annotations\Adapter\Cache  - __construct()');

        $adapter = new Cache([
            'cache' => new Memory(new SerializerFactory(), [])
        ]);

        $class = AdapterInterface::class;
        $I->assertInstanceOf(
            $class,
            $adapter
        );
    }
    /**
     * Tests Phalcon\Incubator\Annotations\Adapter\Cache :: __construct()
     *
     */
    public function annotationsAdapterMemcachedConstructWithoutCache(UnitTester $I)
    {
        $I->wantToTest('Annotations\Adapter\Cache  - __construct() without cache');



        $I->expectThrowable(
            Exception::class,
            function () {
                $adapter = new Cache([]);
            }
        );
    }
}
