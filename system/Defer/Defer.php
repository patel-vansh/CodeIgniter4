<?php

namespace CodeIgniter\Defer;

class Defer
{
    /**
     * @var list<callable>
     */
    protected static array $callbacks = [];

    public static function add(callable $callback): void
    {
        self::$callbacks[] = $callback;
    }

    public static function run(): void
    {
        while ($callbacks = self::$callbacks) {
            self::$callbacks = [];

            foreach ($callbacks as $callback) {
                ($callback)();
            }
        }
    }
}
