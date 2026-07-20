<?php

namespace CodeIgniter\Defer;

use CodeIgniter\Test\CIUnitTestCase;
use PHPUnit\Framework\Attributes\Group;

/**
 * @internal
 */
#[Group('Others')]
final class DeferTest extends CIUnitTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        Defer::reset();
    }

    public function testRun(): void
    {
        $called = false;

        Defer::add(function () use (&$called) {
            $called = true;
        });

        Defer::run();

        $this->assertTrue($called);
    }

    public function testRunMultiple(): void
    {
        $called = 0;

        Defer::add(function () use (&$called) {
            $called++;
        });

        Defer::add(function () use (&$called) {
            $called++;
        });

        Defer::run();

        $this->assertSame(2, $called);
    }

    public function testRunNested(): void
    {
        $called = 0;

        Defer::add(function () use (&$called) {
            $called++;

            Defer::add(function () use (&$called) {
                $called++;
            });
        });

        Defer::run();

        $this->assertSame(2, $called);
    }

    public function testReset(): void
    {
        $called = false;

        Defer::add(function () use (&$called) {
            $called = true;
        });

        Defer::reset();

        Defer::run();

        $this->assertFalse($called);
    }
}
