<?php

declare(strict_types=1);

namespace Flow\ETL\Tests\Integration\Function;

use function Flow\ETL\DSL\{from_array, lit, ref, to_memory};
use Flow\ETL\Flow;
use Flow\ETL\Memory\ArrayMemory;
use PHPUnit\Framework\TestCase;

final class PregReplaceTest extends TestCase
{
    public function test_preg_replace() : void
    {
        (new Flow())
            ->read(
                from_array(
                    [
                        ['key' => 'value'],
                    ]
                )
            )
            ->withEntry('preg_replace', ref('key')->regexReplace(lit('/e/'), lit('es')))
            ->write(to_memory($memory = new ArrayMemory()))
            ->run();

        self::assertSame(
            [
                ['key' => 'value', 'preg_replace' => 'values'],
            ],
            $memory->dump()
        );
    }

    public function test_preg_replace_on_non_string_key() : void
    {
        (new Flow())
            ->read(
                from_array(
                    [
                        ['id' => 1],
                    ]
                )
            )
            ->withEntry('preg_replace', ref('id')->regexReplace(lit('1'), lit(1)))
            ->write(to_memory($memory = new ArrayMemory()))
            ->run();

        self::assertSame(
            [
                ['id' => 1, 'preg_replace' => null],
            ],
            $memory->dump()
        );
    }

    public function test_preg_replace_on_non_string_value() : void
    {
        (new Flow())
            ->read(
                from_array(
                    [
                        ['id' => '1'],
                    ]
                )
            )
            ->withEntry('preg_replace', ref('id')->regexReplace(lit(1), lit('1')))
            ->write(to_memory($memory = new ArrayMemory()))
            ->run();

        self::assertSame(
            [
                ['id' => '1', 'preg_replace' => null],
            ],
            $memory->dump()
        );
    }
}
