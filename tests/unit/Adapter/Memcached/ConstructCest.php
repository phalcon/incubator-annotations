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

namespace Phalcon\Incubator\Annotations\Tests\Unit\Adapter\Memcached;

use Phalcon\Annotations\Adapter\AdapterInterface;
use Phalcon\Annotations\Exception;
use Phalcon\Incubator\Annotations\Adapter\Memcached;
use UnitTester;

final class ConstructCest
{
    /**
     * Tests Phalcon\Incubator\Annotations\Adapter\Memcached :: __construct()
     *
     * @param UnitTester $I
     *
     * @throws Exception
     */
    public function annotationsAdapterMemcachedConstruct(UnitTester $I)
    {
        $I->wantToTest('Annotations\Adapter\Memcached  - __construct()');

        $adapter = new Memcached([
            'prefix'   => 'annotations_',
            'lifetime' => 3600,
            'host' => '127.0.0.1',
        ]);

        $I->assertInstanceOf(AdapterInterface::class, $adapter);
    }

    /**
     * Tests Phalcon\Incubator\Annotations\Adapter\Memcached :: __construct()
     *
     * @param UnitTester $I
     */
    public function annotationsAdapterMemcachedConstructWithoutHost(UnitTester $I)
    {
        $I->wantToTest('Annotations\Adapter\Memcached  - __construct() without host');

        $I->expectThrowable(
            Exception::class,
            function () {
                $adapter = new Memcached([]);
            }
        );
    }
}
