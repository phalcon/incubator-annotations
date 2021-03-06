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

namespace Phalcon\Incubator\Annotations\Tests\Functional\Adapter\Memcached;

use FunctionalTester;
use Phalcon\Annotations\Exception;
use Phalcon\Incubator\Annotations\Adapter\Memcached;
use TestClass;

final class ReadWriteCest
{
    /**
     * Tests Phalcon\Incubator\Annotations\Adapter\Cache :: read() / write()
     *
     * @param FunctionalTester $I
     * @throws Exception
     */
    public function annotationsAdapterMemcachedReadAndWrite(FunctionalTester $I)
    {
        $I->wantToTest('Annotations\Adapter\Cache - read() / write()');

        require_once codecept_data_dir('fixtures/Annotations/TestClass.php');

        $adapter = new Memcached([
            'host' => getenv('DATA_MEMCACHED_HOST'),
            'port' => getenv('DATA_MEMCACHED_PORT'),
        ]);
        $reflection = $adapter->get(TestClass::class);

        $I->assertTrue($adapter->write("test", $reflection));
        $I->assertEquals($reflection, $adapter->read("test"));
    }
}
