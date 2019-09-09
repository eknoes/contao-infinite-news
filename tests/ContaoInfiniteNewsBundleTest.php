<?php

/*
 * This file is part of [package name].
 *
 * (c) John Doe
 *
 * @license LGPL-3.0-or-later
 */

namespace Eknoes\ContaoInfiniteNewsBundle\Tests;

use Eknoes\ContaoInfiniteNews\ContaoInfiniteNewsBundle;
use PHPUnit\Framework\TestCase;

class ContaoInfiniteNewsBundleTest extends TestCase
{
    public function testCanBeInstantiated()
    {
        $bundle = new ContaoInfiniteNewsBundle();

        $this->assertInstanceOf('Eknoes\ContaoInfiniteNews\ContaoInfiniteNewsBundle', $bundle);
    }
}
