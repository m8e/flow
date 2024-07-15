<?php

declare(strict_types=1);

namespace Flow\Dremel\Tests\Unit;

use Flow\Dremel\Dremel;
use Flow\Dremel\Exception\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class DremelAssembleTest extends TestCase
{
    public function test_assembly_shred_on_nested_nullable_lists() : void
    {
        $repetitions = [0, 2, 2, 0, 2, 0, 2, 2];
        $definitions = [2, 2, 2, 1, 1, 2, 2, 2];
        $values = [0, 1, 2, 4, 5, 6];

        self::assertSame(
            [[[0, 1, 2]], [[null, null]], [[4, 5, 6]]],
            (new Dremel())->assemble($repetitions, $definitions, $values, 2, 2)
        );
    }

    public function test_decode_column_of_integer_list() : void
    {
        $repetitions = [0, 1, 1, 0, 1, 1, 0, 1, 1, 0, 1, 1, 0, 1, 1, 0, 1, 1, 0, 1, 1, 0, 1, 1, 0, 1, 1, 0, 1, 1];
        $definitions = [3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3];
        $values = [3, 7, 5, 4, 4, 7, 10, 6, 4, 10, 3, 2, 10, 4, 4, 5, 3, 2, 1, 4, 3, 4, 3, 9, 10, 3, 4, 5, 7, 4];

        self::assertSame(
            [[3, 7, 5], [4, 4, 7], [10, 6, 4], [10, 3, 2], [10, 4, 4], [5, 3, 2], [1, 4, 3], [4, 3, 9], [10, 3, 4], [5, 7, 4]],
            (new Dremel())->assemble($repetitions, $definitions, $values, 3, 1)
        );
    }

    public function test_decode_flat_column_of_integers_where_every_second_one_is_null() : void
    {
        $repetitions = [];
        $definitions = [1, 0, 1, 0, 1, 0, 1, 0, 1, 0];
        $values = [0, 2, 4, 6, 8];

        self::assertSame(
            [0, null, 2, null, 4, null, 6, null, 8, null],
            (new Dremel())->assemble($repetitions, $definitions, $values, 1, 0)
        );
    }

    public function test_decode_flat_column_of_integers_without_nulls() : void
    {
        $repetitions = [];
        $definitions = [1, 1, 1, 1, 1, 1, 1, 1, 1, 1];
        $values = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];

        self::assertSame(
            [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
            (new Dremel())->assemble($repetitions, $definitions, $values, 1, 0)
        );
    }

    public function test_decode_list_with_nulls_and_different_size_of_each_list() : void
    {
        $repetitions = [0, 0, 1, 1, 0, 0, 1, 0, 0, 1, 1, 1, 1, 0, 0, 1, 1, 0, 1, 1, 0, 1];
        $definitions = [3, 3, 2, 2, 3, 3, 2, 3, 3, 2, 2, 2, 2, 3, 3, 2, 2, 3, 2, 2, 3, 2];
        $values = [10, 7, 9, 8, 9, 4, 6, 3, 10, 8];

        self::assertSame(
            [[10], [7, null, null], [9], [8, null], [9], [4, null, null, null, null], [6], [3, null, null], [10, null, null], [8, null]],
            (new Dremel())->assemble($repetitions, $definitions, $values, 3, 1)
        );
    }

    public function test_decode_nested_list_v2() : void
    {
        $repetitions = [0, 3, 3, 2, 3, 3, 1, 3, 2, 3, 2, 3, 3, 1, 3, 0, 3, 3, 2, 3, 3, 2, 3, 3, 1, 3, 2, 1, 3, 3, 2, 3, 3, 0, 3, 3, 1, 3, 2, 1, 3, 2, 2, 3, 0, 3, 3, 2, 3, 2, 3, 3, 0, 3, 3, 0, 1, 3, 2, 3, 1, 3, 3, 2, 3, 0, 2, 3, 3, 2, 1, 2, 3, 0, 3, 3, 2, 3, 3, 0, 3, 3, 2, 2, 3, 1, 2, 3, 0, 1, 0, 3, 1, 3, 1, 3, 3, 2, 0, 3, 2, 3, 3, 1, 3, 0, 2, 3, 1, 3, 2, 2, 0, 2, 3, 1, 2, 3, 3, 1, 3, 3, 2, 3, 0, 3, 0, 3, 3, 2, 3, 3, 1, 3, 3, 2, 2, 3, 3, 0, 2, 1, 3, 2, 2, 0, 3, 3, 1, 3, 2, 2, 1, 3, 3, 0, 3, 3, 1, 3, 3, 2, 3, 3, 2, 3, 3, 1, 3, 2, 0, 3, 2, 3, 3, 2, 3, 1, 3, 3, 2, 3, 3, 1, 2, 0, 3, 2, 3, 2, 3, 1, 1, 3, 3, 2, 3, 3, 2, 0, 3, 0, 2, 0, 3, 1, 3, 3, 1, 2, 0, 1, 2, 3, 3, 0, 3, 3, 1, 3, 3, 2, 3, 2, 3, 3, 1, 3, 3, 0, 3, 3, 2, 1, 3, 0, 3, 3, 0, 3, 2, 1, 3, 3, 2, 2, 3, 1, 3, 2, 3, 0, 2, 1, 3, 2, 3, 3, 2, 3, 0, 3, 2, 0, 2, 3, 2, 3, 3, 1, 3, 3, 2, 0, 3, 0, 3, 3, 1, 2, 3, 0, 3, 3, 1, 3, 2, 3, 3, 1, 2, 3, 2, 3, 0, 3, 1, 3, 3, 2, 2, 3, 1, 3, 3, 2, 3, 3, 0, 3, 3, 2, 3, 1, 2, 1, 3, 3, 2, 3, 0, 1, 3, 3, 2, 3, 2, 3, 0, 3, 2, 2, 3, 1, 3, 3, 2, 3, 0, 2, 0, 3, 3, 1, 3, 2, 3, 3, 1, 2, 2, 3, 0, 3, 2, 3, 3, 1, 3, 3, 1, 2, 3, 0, 1, 3, 3, 2, 0, 3, 1, 3, 0, 3, 2, 2, 3, 3, 0, 2, 3, 0, 3, 3, 2, 3, 3, 0, 3, 3, 0, 2, 3, 3, 2, 3, 1, 3, 2, 2, 1, 3, 3, 2, 3, 3, 2, 0, 3, 3, 2, 3, 1, 3, 3, 0, 1, 3, 3, 2, 3, 1, 2, 3, 3, 2, 0, 3, 3, 2, 3, 1, 1, 3, 3, 2, 3, 3, 2, 3, 0, 3, 3, 1, 3, 3, 2, 3, 3, 1, 3, 2, 3, 0, 3, 2, 3, 1, 0, 3, 3, 2, 0, 3, 2, 3, 2, 0, 3, 3, 1, 3, 3, 0, 1, 1, 2, 3, 3, 0, 3, 1, 3, 2, 2, 3, 1, 3, 2, 0, 3, 2, 3, 3, 2, 3, 1, 3, 3, 2, 3, 3, 2, 3, 1, 3, 2, 0, 3, 3, 2, 3, 3, 1, 3, 1, 0, 3, 2, 3, 3, 2, 1, 2, 2, 0, 2, 3, 2, 3, 1, 2, 2, 1, 3, 3, 2, 3, 3, 2, 3, 3, 0, 0, 3, 3, 1, 3, 2, 3, 2, 3, 0, 3, 3, 2, 3, 1, 3, 3, 2, 3, 1, 3, 2, 0, 3, 2, 2, 0, 3, 2, 2, 3, 3, 1, 0, 1, 3, 0, 3, 3, 2, 3, 1, 3, 2, 3, 3, 2, 3, 3, 0, 3, 3, 2, 3, 0, 3, 3, 2, 3, 3, 0, 3, 3, 2, 3, 2, 0, 2, 3, 1, 3, 2, 2, 3, 1, 3, 0, 3, 3, 2, 1, 2, 3, 3, 1, 2, 0, 3, 1, 3, 3, 2, 3, 0, 3, 2, 3, 3, 1, 3, 0, 2, 3, 3, 0, 2, 1, 3, 3, 2, 3, 2, 0, 2, 3, 2, 3, 1, 2, 3, 3, 0, 2, 1, 2, 2, 3, 1, 0, 3, 3, 2, 3, 3, 2, 3, 3, 0, 3, 3, 1, 2, 3, 2, 1, 3, 2, 2, 3, 0, 0, 2, 3, 2, 3, 0, 3, 2, 1, 3, 1, 2, 2, 3, 3, 0, 3, 3, 1, 3, 3, 2, 3, 3, 0, 3, 3, 2, 3, 3, 1, 1, 3, 3, 2, 3, 3, 0, 3, 1, 2, 3, 0, 2, 3, 3, 1, 3, 0, 3, 2, 3, 1, 3, 3, 1, 2, 3, 3, 0, 3, 2, 3, 0, 3, 1, 3, 3, 0, 3, 2, 0, 3, 3, 0, 2, 3, 3, 2, 0, 3, 2, 3, 2, 3, 1, 0, 2, 3, 3, 0, 3, 3, 2, 1, 3, 3, 2, 2, 3, 1, 2, 0, 3, 2, 3, 2, 1, 3, 3, 1, 3, 2];
        $definitions = [7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7];
        $values = [5, 3, 8, 2, 9, 5, 5, 10, 9, 7, 2, 1, 8, 2, 4, 7, 2, 4, 4, 10, 6, 5, 6, 6, 3, 6, 5, 7, 2, 10, 6, 4, 7, 2, 8, 10, 6, 5, 9, 2, 10, 3, 7, 3, 7, 8, 7, 5, 8, 4, 1, 5, 1, 10, 7, 4, 7, 2, 7, 3, 9, 3, 2, 3, 9, 5, 2, 6, 2, 10, 10, 7, 9, 9, 8, 5, 9, 7, 7, 9, 1, 8, 2, 9, 10, 6, 2, 10, 10, 3, 5, 6, 5, 10, 6, 3, 6, 8, 5, 1, 10, 2, 10, 4, 4, 5, 6, 9, 5, 6, 3, 4, 3, 9, 10, 3, 2, 1, 2, 6, 7, 3, 6, 1, 7, 6, 2, 2, 10, 5, 1, 6, 3, 5, 3, 5, 6, 2, 8, 3, 5, 8, 1, 7, 9, 4, 7, 6, 7, 8, 8, 1, 4, 7, 3, 6, 5, 6, 7, 9, 8, 2, 4, 9, 8, 6, 6, 5, 2, 6, 1, 10, 6, 1, 1, 6, 7, 1, 5, 2, 1, 9, 1, 7, 10, 5, 2, 1, 8, 7, 9, 1, 2, 8, 10, 7, 9, 5, 9, 5, 2, 1, 5, 5, 3, 5, 6, 6, 6, 1, 1, 4, 3, 8, 3, 9, 3, 4, 7, 2, 9, 6, 10, 5, 5, 9, 9, 9, 7, 1, 1, 8, 10, 6, 4, 7, 7, 10, 9, 10, 8, 10, 3, 2, 5, 2, 1, 9, 2, 9, 6, 7, 7, 3, 7, 9, 4, 8, 3, 1, 4, 6, 1, 3, 2, 4, 5, 7, 1, 9, 9, 10, 4, 2, 5, 8, 9, 2, 7, 1, 4, 9, 1, 9, 9, 2, 4, 4, 7, 7, 2, 9, 3, 4, 4, 1, 9, 4, 1, 1, 8, 1, 1, 7, 3, 10, 3, 8, 3, 10, 10, 5, 2, 6, 8, 1, 2, 9, 9, 8, 10, 10, 10, 5, 1, 1, 8, 9, 1, 5, 9, 7, 3, 5, 9, 8, 8, 6, 2, 8, 8, 4, 5, 1, 10, 7, 9, 5, 10, 2, 2, 7, 1, 7, 2, 6, 10, 7, 6, 5, 7, 4, 3, 4, 10, 10, 7, 9, 9, 4, 5, 5, 6, 10, 1, 1, 3, 10, 5, 10, 5, 2, 2, 8, 7, 4, 9, 7, 4, 1, 1, 6, 3, 10, 1, 6, 3, 10, 5, 8, 2, 5, 9, 3, 9, 3, 9, 1, 8, 4, 6, 6, 7, 9, 2, 8, 3, 3, 5, 2, 10, 4, 3, 8, 1, 6, 6, 7, 1, 9, 10, 7, 4, 7, 2, 3, 6, 10, 5, 8, 4, 7, 9, 4, 3, 4, 7, 10, 10, 3, 4, 2, 1, 6, 10, 7, 10, 1, 9, 10, 5, 8, 9, 10, 1, 9, 8, 7, 1, 4, 1, 3, 6, 10, 8, 9, 6, 1, 7, 2, 10, 6, 7, 3, 7, 9, 6, 3, 1, 6, 9, 4, 6, 7, 9, 7, 7, 3, 4, 3, 3, 9, 5, 5, 2, 8, 5, 10, 10, 8, 2, 9, 6, 2, 5, 2, 9, 4, 9, 3, 3, 4, 9, 8, 2, 2, 6, 10, 9, 3, 1, 3, 8, 8, 9, 6, 8, 8, 1, 1, 2, 4, 1, 4, 4, 9, 5, 7, 1, 6, 1, 7, 3, 5, 5, 7, 2, 3, 10, 10, 3, 7, 6, 2, 10, 3, 10, 2, 7, 9, 3, 2, 2, 8, 10, 2, 10, 4, 4, 4, 10, 9, 8, 10, 2, 9, 10, 1, 7, 10, 3, 4, 3, 9, 5, 8, 10, 9, 5, 5, 3, 4, 3, 6, 6, 9, 8, 1, 9, 2, 3, 9, 4, 3, 8, 9, 6, 9, 10, 9, 8, 4, 8, 7, 2, 2, 6, 7, 6, 4, 4, 7, 3, 2, 5, 7, 9, 10, 8, 6, 8, 3, 4, 9, 3, 1, 7, 6, 4, 4, 5, 6, 5, 2, 5, 10, 10, 9, 10, 2, 8, 2, 2, 2, 10, 5, 10, 3, 2, 8, 6, 8, 4, 9, 9, 6, 5, 5, 4, 1, 1, 5, 3, 9, 6, 6, 5, 9, 3, 10, 6, 1, 5, 6, 6, 7, 1, 7, 5, 5, 7, 2, 10, 1, 8, 8, 3, 4, 3, 5, 2, 1, 3, 4, 2, 1, 2, 10, 4, 5, 1, 6, 7, 5, 3, 5, 10, 7, 6, 2, 8, 10, 4, 2, 2, 1, 4, 5, 3, 2, 3, 2, 2, 3, 2, 6, 3, 5, 9, 8, 8, 5, 7, 5, 5, 4, 7, 4, 10, 5, 9, 5, 5, 1, 6, 3, 5, 10, 9, 7, 9, 9, 9, 3, 4, 7, 3, 4, 3, 5, 9, 3, 4, 8, 4, 4, 10, 3, 1, 7, 7, 1, 1, 2, 1, 6, 5, 7, 3, 9, 5, 6, 1, 4, 8, 7];

        self::assertSame(
            [
                [[[5, 3, 8], [2, 9, 5]], [[5, 10], [9, 7], [2, 1, 8]], [[2, 4]]],
                [[[7, 2, 4], [4, 10, 6], [5, 6, 6]], [[3, 6], [5]], [[7, 2, 10], [6, 4, 7]]],
                [[[2, 8, 10]], [[6, 5], [9]], [[2, 10], [3], [7, 3]]],
                [[[7, 8, 7], [5, 8], [4, 1, 5]]],
                [[[1, 10, 7]]],
                [[[4]], [[7, 2], [7, 3]], [[9, 3, 2], [3, 9]]],
                [[[5], [2, 6, 2], [10]], [[10], [7, 9]]],
                [[[9, 8, 5], [9, 7, 7]]],
                [[[9, 1, 8], [2], [9, 10]], [[6], [2, 10]]],
                [[[10]], [[3]]],
                [[[5, 6]], [[5, 10]], [[6, 3, 6], [8]]],
                [[[5, 1], [10, 2, 10]], [[4, 4]]],
                [[[5], [6, 9]], [[5, 6], [3], [4]]],
                [[[3], [9, 10]], [[3], [2, 1, 2]], [[6, 7, 3], [6, 1]]],
                [[[7, 6]]],
                [[[2, 2, 10], [5, 1, 6]], [[3, 5, 3], [5], [6, 2, 8]]],
                [[[3], [5]], [[8, 1], [7], [9]]],
                [[[4, 7, 6]], [[7, 8], [8], [1]], [[4, 7, 3]]],
                [[[6, 5, 6]], [[7, 9, 8], [2, 4, 9], [8, 6, 6]], [[5, 2], [6]]],
                [[[1, 10], [6, 1, 1], [6, 7]], [[1, 5, 2], [1, 9, 1]], [[7], [10]]],
                [[[5, 2], [1, 8], [7, 9]], [[1]], [[2, 8, 10], [7, 9, 5], [9]]],
                [[[5, 2]]],
                [[[1], [5]]],
                [[[5, 3]], [[5, 6, 6]], [[6], [1]]],
                [[[1]], [[4], [3, 8, 3]]],
                [[[9, 3, 4]], [[7, 2, 9], [6, 10], [5, 5, 9]], [[9, 9, 7]]],
                [[[1, 1, 8], [10]], [[6, 4]]],
                [[[7, 7, 10]]],
                [[[9, 10], [8]], [[10, 3, 2], [5], [2, 1]], [[9, 2], [9, 6]]],
                [[[7], [7]], [[3, 7], [9, 4, 8], [3, 1]]],
                [[[4, 6], [1]]],
                [[[3], [2, 4], [5, 7, 1]], [[9, 9, 10], [4]]],
                [[[2, 5]]],
                [[[8, 9, 2]], [[7], [1, 4]]],
                [[[9, 1, 9]], [[9, 2], [4, 4, 7]], [[7], [2, 9], [3, 4]]],
                [[[4, 1]], [[9, 4, 1], [1], [8, 1]], [[1, 7, 3], [10, 3, 8]]],
                [[[3, 10, 10], [5, 2]], [[6], [8]], [[1, 2, 9], [9, 8]]],
                [[[10]], [[10, 10, 5], [1, 1], [8, 9]]],
                [[[1, 5], [9], [7, 3]], [[5, 9, 8], [8, 6]]],
                [[[2], [8]]],
                [[[8, 4, 5]], [[1, 10], [7, 9, 5]], [[10], [2], [2, 7]]],
                [[[1, 7], [2, 6, 10]], [[7, 6, 5]], [[7], [4, 3]]],
                [[[4]], [[10, 10, 7], [9]]],
                [[[9, 4]], [[5, 5]]],
                [[[6, 10], [1], [1, 3, 10]]],
                [[[5], [10, 5]]],
                [[[2, 2, 8], [7, 4, 9]]],
                [[[7, 4, 1]]],
                [[[1], [6, 3, 10], [1, 6]], [[3, 10], [5], [8]], [[2, 5, 9], [3, 9, 3], [9]]],
                [[[1, 8, 4], [6, 6]], [[7, 9, 2]]],
                [[[8]], [[3, 3, 5], [2, 10]], [[4], [3, 8, 1], [6]]],
                [[[6, 7, 1], [9, 10]], [[7]], [[4, 7, 2], [3, 6, 10], [5, 8]]],
                [[[4, 7, 9]], [[4, 3, 4], [7, 10, 10]], [[3, 4], [2, 1]]],
                [[[6, 10], [7, 10]], [[1]]],
                [[[9, 10, 5], [8]]],
                [[[9, 10], [1, 9], [8]]],
                [[[7, 1, 4]], [[1, 3, 6]]],
                [[[10]], [[8]], [[9], [6, 1, 7]]],
                [[[2, 10]], [[6, 7], [3], [7, 9]], [[6, 3], [1]]],
                [[[6, 9], [4, 6, 7], [9, 7]], [[7, 3, 4], [3, 3, 9], [5, 5]], [[2, 8], [5]]],
                [[[10, 10, 8], [2, 9, 6]], [[2, 5]], [[2]]],
                [[[9, 4], [9, 3, 3], [4]], [[9], [8], [2]]],
                [[[2], [6, 10], [9, 3]], [[1], [3], [8]], [[8, 9, 6], [8, 8, 1], [1, 2, 4]]],
                [[[1]]],
                [[[4, 4, 9]], [[5, 7], [1, 6], [1, 7]]],
                [[[3, 5, 5], [7, 2]], [[3, 10, 10], [3, 7]], [[6, 2], [10]]],
                [[[3, 10], [2], [7]]],
                [[[9, 3], [2], [2, 8, 10]], [[2]]],
                [[[10]], [[4, 4]]],
                [[[4, 10, 9], [8, 10]], [[2, 9], [10, 1, 7], [10, 3, 4]]],
                [[[3, 9, 5], [8, 10]]],
                [[[9, 5, 5], [3, 4, 3]]],
                [[[6, 6, 9], [8, 1], [9]]],
                [[[2], [3, 9]], [[4, 3], [8], [9, 6]], [[9, 10]]],
                [[[9, 8, 4], [8]], [[7], [2, 2, 6]], [[7], [6]]],
                [[[4, 4]], [[7, 3, 2], [5, 7]]],
                [[[9, 10], [8, 6, 8]], [[3, 4]]],
                [[[9], [3, 1, 7]]],
                [[[6], [4]], [[4, 5, 6], [5, 2], [5]]],
                [[[10], [10, 9], [10, 2]], [[8], [2, 2, 2]]],
                [[[10], [5]], [[10], [3], [2, 8]], [[6]]],
                [[[8, 4, 9], [9, 6, 5], [5, 4, 1]]],
                [[[1, 5, 3]], [[9], [6, 6], [5]], [[9, 3], [10], [6, 1]]],
                [[[5]]], [[[6], [6, 7], [1, 7]]],
                [[[5, 5], [7]], [[2, 10]], [[1], [8], [8, 3, 4]]],
                [[[3, 5, 2]], [[1, 3, 4], [2, 1, 2]]],
                [[[10, 4, 5], [1, 6, 7]], [[5]], [[3, 5, 10], [7, 6, 2]]],
                [[[8, 10]], [[4], [2, 2]]],
                [[[1], [4, 5, 3]], [[2, 3]]],
                [[[2, 2], [3, 2]], [[6, 3, 5]], [[9], [8, 8, 5]]],
                [[[7, 5], [5, 4]]],
                [[[7, 4]], [[10, 5, 9]]],
                [[[5, 5], [1]]],
                [[[6, 3, 5]]],
                [[[10], [9, 7, 9], [9]]],
                [[[9, 3], [4, 7], [3, 4]], [[3]]],
                [[[5], [9, 3, 4]]],
                [[[8, 4, 4], [10]], [[3, 1, 7], [7], [1, 1]], [[2], [1]]],
                [[[6, 5], [7, 3], [9]], [[5, 6, 1]], [[4, 8], [7]]],
            ],
            (new Dremel())->assemble($repetitions, $definitions, $values, 7, 3)
        );
    }

    public function test_decode_nullable_column_of_integer_list() : void
    {
        $repetitions = [0, 1, 1, 0, 0, 1, 1, 0, 0, 1, 1, 0, 0, 1, 1, 0, 0, 1, 1, 0];
        $definitions = [3, 3, 3, 0, 3, 3, 3, 0, 3, 3, 3, 0, 3, 3, 3, 0, 3, 3, 3, 0];
        $values = [5, 9, 2, 3, 2, 9, 5, 2, 3, 7, 2, 3, 2, 6, 6, null, null, null, null, null];

        self::assertSame(
            [[5, 9, 2], null, [3, 2, 9], null, [5, 2, 3], null, [7, 2, 3], null, [2, 6, 6], null],
            (new Dremel())->assemble($repetitions, $definitions, $values, 3, 1)
        );
    }

    public function test_decode_when_repetitions_definitions_and_values_does_not_have_them_same_number_of_elements() : void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('repetitions, definitions and values count must be exactly the same');

        \iterator_to_array((new Dremel())->assemble([1, 2], [1], [1, 2], 1, 1));
    }

    public function test_reconstructing_map() : void
    {
        $repetitions = [0, 4, 4, 1, 4, 3, 2, 4, 3, 4, 3, 4, 2, 1, 2, 4, 4, 3, 4, 0, 4, 2, 4, 4, 2, 4, 4, 3, 1, 4, 3, 4, 4, 2, 4, 4, 2, 1, 4, 2, 4, 4, 2, 3, 4, 4];
        $definitions = [11, 11, 11, 11, 11, 11, 11, 11, 11, 11, 11, 11, 11, 11, 11, 11, 11, 11, 11, 11, 11, 11, 11, 11, 11, 11, 11, 11, 11, 11, 11, 11, 11, 11, 11, 11, 11, 11, 11, 11, 11, 11, 11, 11, 11, 11];
        $values = [6, 10, 10, 5, 9, 8, 4, 7, 4, 7, 1, 6, 6, 10, 6, 6, 1, 5, 8, 5, 2, 6, 3, 9, 9, 10, 7, 9, 4, 6, 5, 10, 3, 5, 4, 7, 6, 3, 5, 7, 5, 2, 8, 3, 8, 5];

        self::assertSame(
            [
                [
                    [
                        [
                            [6, 10, 10],
                        ],
                    ],
                    [
                        [
                            [5, 9],
                            [8],
                        ],
                        [
                            [4, 7],
                            [4, 7],
                            [1, 6],
                        ],
                        [
                            [6],
                        ],
                    ],
                    [
                        [
                            [10],
                        ],
                        [
                            [6, 6, 1],
                            [5, 8],
                        ],
                    ],
                ],
                [
                    [
                        [
                            [5, 2],
                        ],
                        [
                            [6, 3, 9],
                        ],
                        [
                            [9, 10, 7],
                            [9],
                        ],
                    ],
                    [
                        [
                            [4, 6],
                            [5, 10, 3],
                        ],
                        [
                            [5, 4, 7],
                        ],
                        [
                            [6],
                        ],
                    ],
                    [
                        [
                            [3, 5],
                        ],
                        [
                            [7, 5, 2],
                        ],
                        [
                            [8],
                            [3, 8, 5],
                        ],
                    ],
                ],
            ],
            (new Dremel())->assemble($repetitions, $definitions, $values, 11, 4)
        );
    }

    public function test_starting_repetitions_with_1() : void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Repetitions must start with zero, otherwise it probably means that your data was split into multiple pages in which case proper reconstruction of rows is impossible.');

        $repetitions = [1, 0, 0, 1, 0, 1];
        $definitions = [4, 4, 4, 4, 4, 4];
        $values = ['value', 'value', 'value', 'value', 'value', 'value'];

        (new Dremel())->assemble($repetitions, $definitions, $values, 1, 1);
    }
}
