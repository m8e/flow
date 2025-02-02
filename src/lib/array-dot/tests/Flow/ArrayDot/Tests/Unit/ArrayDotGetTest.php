<?php

declare(strict_types=1);

namespace Flow\ArrayDot\Tests\Unit;

use function Flow\ArrayDot\{array_dot_exists,
    array_dot_get,
    array_dot_get_bool,
    array_dot_get_datetime,
    array_dot_get_enum,
    array_dot_get_float,
    array_dot_get_int,
    array_dot_get_string};
use Flow\ArrayDot\Exception\InvalidPathException;
use Flow\ArrayDot\Tests\Unit\Fixtures\{Letters, Numbers};
use PHPUnit\Framework\TestCase;

final class ArrayDotGetTest extends TestCase
{
    public function test_accessing_array_scalar_value_by_path_multiple_asterix_paths() : void
    {
        self::assertSame(
            [
                ['12345', '22222'],
                ['3333'],
            ],
            array_dot_get(
                [
                    'transactions' => [
                        [
                            'id' => 1,
                            'packages' => [
                                [
                                    'label_id' => '12345',
                                ],
                                [
                                    'label_id' => '22222', ],
                            ],
                        ],
                        [
                            'id' => 1,
                            'packages' => [
                                [
                                    'label_id' => '3333',
                                ],
                            ],
                        ],
                    ],
                ],
                'transactions.*.packages.*.label_id'
            ),
        );
    }

    public function test_accessing_array_scalar_value_by_path_multiple_asterix_paths_with_nullsafe() : void
    {
        self::assertSame(
            [
                ['12345', '22222'],
                ['3333'],
                [null],
            ],
            array_dot_get(
                [
                    'transactions' => [
                        [
                            'id' => 1,
                            'packages' => [
                                [
                                    'label_id' => '12345',
                                ],
                                [
                                    'label_id' => '22222',
                                ],
                            ],
                        ],
                        [
                            'id' => 1,
                            'packages' => [
                                [
                                    'label_id' => '3333',
                                ],
                            ],
                        ],
                        [
                            'id' => 1,
                            'packages' => [
                                [
                                    'foo' => 'bar',
                                ],
                            ],
                        ],
                    ],
                ],
                'transactions.*.packages.*.?label_id'
            ),
        );
    }

    public function test_accessing_array_scalar_value_by_path_with_asterix() : void
    {
        self::assertSame(
            ['Michael', 'Jack'],
            array_dot_get(
                [
                    'users' => [
                        [
                            'user' => [
                                'id' => 1,
                                'name' => 'Michael',
                            ],
                        ],
                        [
                            'user' => [
                                'id' => 2,
                                'name' => 'Jack',
                            ],
                        ],
                    ],
                ],
                'users.*.user.name'
            ),
        );
    }

    public function test_accessing_array_scalar_value_by_path_with_asterix_and_different_elements() : void
    {
        $this->expectException(InvalidPathException::class);
        $this->expectExceptionMessage("Path \"user.name\" does not exists in array \"array('user'=>array('id'=>2,),)\"");

        array_dot_get(
            [
                'users' => [
                    [
                        'user' => [
                            'id' => 1,
                            'name' => 'Michael',
                        ],
                    ],
                    [
                        'user' => [
                            'id' => 2,
                        ],
                    ],
                ],
            ],
            'users.*.user.name'
        );
    }

    public function test_accessing_array_scalar_value_by_path_with_asterix_and_different_elements_using_nullsafe() : void
    {
        self::assertSame(
            ['Michael', null],
            array_dot_get(
                [
                    'users' => [
                        [
                            'user' => [
                                'id' => 1,
                                'name' => 'Michael',
                            ],
                        ],
                        [
                            'user' => [
                                'id' => 2,
                            ],
                        ],
                    ],
                ],
                'users.*.user.?name'
            ),
        );
    }

    public function test_accessing_array_scalar_value_by_path_with_escaped_nullable_asterix() : void
    {
        self::assertSame(
            'Michael',
            array_dot_get(
                [
                    'users' => [
                        '?*' => [
                            'id' => 1, 'name' => 'Michael',
                        ],
                    ],
                ],
                'users.\\?*.name'
            )
        );
    }

    public function test_accessing_array_scalar_value_by_path_with_escaped_wildcard_key() : void
    {
        self::assertSame(
            'Michael',
            array_dot_get(
                [
                    'users' => [
                        '*' => [
                            'id' => 1,
                            'name' => 'Michael',
                        ],
                    ],
                ],
                'users.\\*.name'
            ),
        );
    }

    public function test_accessing_array_scalar_value_by_path_with_nullable_asterix_and_different_elements() : void
    {
        self::assertSame(
            ['Michael'],
            array_dot_get(
                [
                    'users' => [
                        [
                            'user' => [
                                'id' => 1,
                                'name' => 'Michael',
                            ],
                        ],
                        [
                            'user' => [
                                'id' => 2,
                            ],
                        ],
                    ],
                ],
                'users.?*.user.name'
            ),
        );
    }

    public function test_accessing_array_value_by_invalid_path() : void
    {
        $this->expectException(InvalidPathException::class);
        $this->expectExceptionMessage("Path \"invalid_path\" does not exists in array \"array('user'=>array('id'=>1,),)\"");

        self::assertSame(array_dot_get(['user' => ['id' => 1]], 'invalid_path'), 1);
    }

    public function test_accessing_array_value_by_nullsafe_path() : void
    {
        self::assertNull(
            array_dot_get(
                [
                    'user' => [
                        'id' => 1,
                    ],
                ],
                'user.?name'
            )
        );
        self::assertNull(
            array_dot_get(
                [
                    'user' => [
                        'role' => [
                            'name' => 'admin',
                        ],
                    ],
                ],
                'user.?wrong_path.name'
            )
        );
        self::assertNull(
            array_dot_get(
                [
                    'users' => [],
                ],
                'users.?0.name'
            )
        );
    }

    public function test_accessing_array_value_by_path() : void
    {
        self::assertSame(
            1,
            array_dot_get(
                [
                    'user' => [
                        'id' => 1,
                    ],
                ],
                'user.id'
            )
        );
        self::assertTrue(
            array_dot_exists(
                [
                    'user' => [
                        'id' => 1,
                    ],
                ],
                'user.id'
            )
        );
        self::assertFalse(
            array_dot_exists(
                [
                    'user' => [
                        'id' => 1,
                    ],
                ],
                'invalid_path'
            )
        );
    }

    public function test_accessing_array_value_by_path_with_asterix() : void
    {
        self::assertSame(
            [
                [
                    'id' => 1,
                    'name' => 'Michael',
                ],
                [
                    'id' => 2,
                    'name' => 'Jack',
                ],
            ],
            array_dot_get(
                [
                    'users' => [
                        [
                            'user' => [
                                'id' => 1,
                                'name' => 'Michael',
                            ],
                        ],
                        [
                            'user' => [
                                'id' => 2,
                                'name' => 'Jack',
                            ],
                        ],
                    ],
                ],
                'users.*.user'
            ),
        );
    }

    public function test_accessing_empty_array_value_by_invalid_path() : void
    {
        $this->expectException(InvalidPathException::class);
        $this->expectExceptionMessage('Path "invalid_path" does not exists in array "array()"');

        self::assertSame(array_dot_get([], 'invalid_path'), 1);
    }

    public function test_accessing_nested_array_value_by_numeric_path() : void
    {
        self::assertSame(
            1,
            array_dot_get(
                [
                    'users' => [
                        [
                            'user' => [
                                'id' => 1,
                            ],
                        ],
                    ],
                ],
                'users.0.user.id'
            )
        );
    }

    public function test_accessing_nested_collection_using_wildcard() : void
    {
        self::assertSame(
            [
                [
                    'id' => 1,
                    'name' => 'Michael',
                ],
                [
                    'id' => 2,
                    'name' => 'Rocky',
                ],
            ],
            array_dot_get(
                [
                    'users' => [
                        [
                            'id' => 1,
                            'name' => 'Michael',
                        ],
                        [
                            'id' => 2,
                            'name' => 'Rocky',
                        ],
                    ],
                ],
                'users.*'
            ),
        );
    }

    public function test_accessing_not_nested_nullsafe() : void
    {
        self::assertNull(
            array_dot_get(
                [
                    '@name' => 'Test',
                ],
                '?@id'
            )
        );
    }

    public function test_accessing_not_nested_nullsafe_on_empty_array() : void
    {
        self::assertNull(
            array_dot_get(
                [
                ],
                '?@id'
            )
        );
    }

    public function test_accessing_null_value_under_existing_path() : void
    {
        self::assertTrue(
            array_dot_exists(
                [
                    'user' => [
                        'id' => null,
                    ],
                ],
                'user.id'
            )
        );
        self::assertFalse(
            array_dot_exists(
                [
                    'user' => [
                        'id' => null,
                    ],
                ],
                'user.ids'
            )
        );
        self::assertTrue(
            array_dot_exists(
                [
                    'user' => [
                        'id' => null,
                    ],
                ],
                '?user?.ids'
            )
        );
    }

    public function test_all_multi_key_get() : void
    {
        self::assertSame(
            [
                ['id' => 1, 'name' => 'foo'],
                ['id' => 2, 'name' => 'bar'],
                ['id' => 3, 'name' => 'baz'],
            ],
            array_dot_get(
                [
                    'array' => [
                        [
                            'id' => 1,
                            'name' => 'foo',
                        ],
                        [
                            'id' => 2,
                            'name' => 'bar',
                        ],
                        [
                            'id' => 3,
                            'name' => 'baz',
                        ],
                    ],
                ],
                'array.*.{id, name}'
            ),
        );
    }

    public function test_all_multi_key_get_nested() : void
    {
        self::assertSame(
            [
                ['id' => 1, 'name' => 'foo', 'property_status_value' => 'active'],
                ['id' => 2, 'name' => 'bar', 'property_status_value' => 'active'],
                ['id' => 3, 'name' => 'baz', 'property_status_value' => 'disabled'],
            ],
            array_dot_get(
                [
                    'array' => [
                        [
                            'id' => 1,
                            'name' => 'foo',
                            'property' => ['status' => ['value' => 'active']],
                        ],
                        [
                            'id' => 2,
                            'name' => 'bar',
                            'property' => ['status' => ['value' => 'active']],
                        ],
                        [
                            'id' => 3,
                            'name' => 'baz',
                            'property' => ['status' => ['value' => 'disabled']],
                        ],
                    ],
                ],
                'array.*.{id, name,    property.?status.value}'
            ),
        );
    }

    public function test_array_dot_get_boolean() : void
    {
        self::assertTrue(
            array_dot_get_bool(['active' => true], 'active')
        );

        self::assertFalse(
            array_dot_get_bool(['active' => false], 'active')
        );

        self::assertNull(
            array_dot_get_bool(['activate' => 'true'], '?active')
        );
    }

    public function test_array_dot_get_datetime() : void
    {
        self::assertEquals(
            new \DateTimeImmutable('2021-01-01 00:00:00'),
            array_dot_get_datetime(['created_at' => '2021-01-01 00:00:00'], 'created_at')
        );

        self::assertNull(
            array_dot_get_datetime(['created_at' => '2021-01-01 00:00:00'], '?updated_at')
        );
    }

    public function test_array_dot_get_enum() : void
    {
        self::assertSame(
            Numbers::ONE,
            array_dot_get_enum(['id' => 1], 'id', Numbers::class)
        );

        self::assertSame(
            Letters::A,
            array_dot_get_enum(['id' => 'A'], 'id', Letters::class)
        );

        self::assertSame(
            Numbers::ONE,
            array_dot_get_enum(['id' => '1'], 'id', Numbers::class)
        );

        self::assertNull(
            array_dot_get_enum(['identifier' => 1], '?id', Numbers::class)
        );
    }

    public function test_array_dot_get_float() : void
    {
        self::assertSame(
            1.0,
            array_dot_get_float(['id' => 1.0], 'id')
        );

        self::assertSame(
            10.0,
            array_dot_get_float(['id' => 10], 'id')
        );

        self::assertSame(
            1.0,
            array_dot_get_float(['id' => '1.0'], 'id')
        );

        self::assertNull(
            array_dot_get_float(['identifier' => 1.0], '?id')
        );
    }

    public function test_array_dot_get_int() : void
    {
        self::assertSame(
            1,
            array_dot_get_int(['id' => 1], 'id')
        );

        self::assertSame(
            1,
            array_dot_get_int(['id' => '01'], 'id')
        );

        self::assertNull(
            array_dot_get_int(['identifier' => 1], '?id')
        );
    }

    public function test_array_dot_get_string() : void
    {
        self::assertSame(
            'foo',
            array_dot_get_string(['name' => 'foo'], 'name')
        );

        self::assertSame(
            '1',
            array_dot_get_string(['name' => 1], 'name')
        );

        self::assertNull(
            array_dot_get_string(['identifier' => 'foo'], '?name')
        );
    }

    public function test_escape_dot_path() : void
    {
        self::assertSame(
            'baz',
            array_dot_get(
                [
                    'user' => [
                        'id' => 1,
                        'foo.bar' => 'baz',
                    ],
                ],
                'user.foo\\.bar'
            ),
        );
    }

    public function test_escape_multi_key_syntax() : void
    {
        self::assertSame(
            1,
            array_dot_get(
                [
                    'array' => [
                        '{id}' => 1,
                    ],
                ],
                'array.\\{id\\}'
            ),
        );
    }

    public function test_get_nullsafe_wildcard_from_not_array() : void
    {
        $this->expectException(InvalidPathException::class);
        $this->expectExceptionMessage('Expected array under path, "?*", but got: integer');

        array_dot_get(
            [
                'id' => 1,
                'status' => 'NEW',
            ],
            '?*.{id}'
        );
    }

    public function test_get_wildcard_from_not_array() : void
    {
        $this->expectException(InvalidPathException::class);
        $this->expectExceptionMessage('Expected array under path, "*", but got: integer');

        array_dot_get(
            [
                'id' => 1,
                'status' => 'NEW',
            ],
            '*.{id}'
        );
    }

    public function test_single_multi_key_get() : void
    {
        self::assertSame(
            [
                'id' => 1, 'name' => 'foo',
            ],
            array_dot_get(
                [
                    'array' => [
                        [
                            'id' => 1,
                            'name' => 'foo',
                        ],
                        [
                            'id' => 2,
                            'name' => 'bar',
                        ],
                        [
                            'id' => 3,
                            'name' => 'baz',
                        ],
                    ],
                ],
                'array.0.{id,name}'
            ),
        );
    }

    public function test_single_nullsafe_multi_key_get() : void
    {
        self::assertSame(
            [
                'id' => 1, 'name' => null,
            ],
            array_dot_get(
                [
                    'array' => [
                        [
                            'id' => 1,
                        ],
                        [
                            'id' => 2,
                            'name' => 'bar',
                        ],
                        [
                            'id' => 3,
                            'name' => 'baz',
                        ],
                    ],
                ],
                'array.0.{id,?name}'
            ),
        );
    }
}
