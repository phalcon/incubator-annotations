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

namespace Phalcon\Incubator\Annotations\Tests\Unit\Adapter\Redis;

use Phalcon\Annotations\Adapter\AdapterInterface;
use Phalcon\Incubator\Annotations\Adapter\Redis;
use UnitTester;

class ConstructCest
{
    /**
     * Tests Phalcon\Incubator\Annotations\Adapter\Redis :: __construct()
     *
     */
    public function annotationsAdapterMemcachedConstruct(UnitTester $I)
    {
        $I->wantToTest('Annotations\Adapter\Redis  - __construct()');

        $adapter = new Redis([]);

        $class = AdapterInterface::class;
        $I->assertInstanceOf(
            $class,
            $adapter
        );
    }
}
