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

use Phalcon\Cache\Adapter\Memory;
use Phalcon\Incubator\Annotations\Adapter\Cache;
use Phalcon\Storage\SerializerFactory;
use TestClass;
use UnitTester;

class WriteCest
{
    /**
     * Tests Phalcon\Incubator\Annotations\Adapter\Cache :: write()
     *
     */
    public function annotationsAdapterMemcachedRead(UnitTester $I)
    {
        $I->wantToTest('Annotations\Adapter\Cache  - write()');

        require_once dataDir('fixtures/Annotations/TestClass.php');

        $cache = new Memory(new SerializerFactory(), []);

        $adapter = new Cache([
            'cache' => $cache
        ]);

        $reflection = $adapter->get(TestClass::class);

        $I->assertTrue($adapter->write("test", $reflection));

        $I->assertEquals(
            $reflection,
            $cache->get("test")
        );
    }
}
