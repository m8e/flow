<?php

declare(strict_types=1);

namespace Flow\ETL\Tests\Unit\Function;

use function Flow\ETL\DSL\{lit, regex_match_all};
use Flow\ETL\Row;
use PHPUnit\Framework\TestCase;

final class PregMatchAllTest extends TestCase
{
    public function test_preg_match_all_expression_on_invalid_flags() : void
    {
        $pregMatchAll = regex_match_all(
            lit('/\d+/'),
            lit('12 apples and 45 oranges'),
            lit('invalid')
        );

        self::assertSame(
            [],
            $pregMatchAll->eval(Row::create())
        );
    }

    public function test_preg_match_all_expression_on_invalid_pattern() : void
    {
        $pregMatchAll = regex_match_all(
            lit(1),
            lit('12 apples and 45 oranges')
        );

        self::assertSame(
            [],
            $pregMatchAll->eval(Row::create())
        );
    }

    public function test_preg_match_all_expression_on_invalid_subject() : void
    {
        $pregMatchAll = regex_match_all(
            lit('/\d+/'),
            lit(2)
        );

        self::assertSame(
            [],
            $pregMatchAll->eval(Row::create())
        );
    }

    public function test_preg_match_all_expression_on_valid_strings() : void
    {
        $pregMatchAll = regex_match_all(
            lit('/\d+/'),
            lit('12 apples and 45 oranges')
        );

        self::assertSame(
            [['12', '45']],
            $pregMatchAll->eval(Row::create())
        );
    }

    public function test_preg_match_all_expression_on_valid_strings_with_flags() : void
    {
        $pregMatchAll = regex_match_all(
            lit('/(\d+)/'),
            lit('12 apples and 45 oranges'),
            lit(PREG_PATTERN_ORDER)
        );

        self::assertSame(
            [['12', '45'], ['12', '45']],
            $pregMatchAll->eval(Row::create())
        );
    }
}
