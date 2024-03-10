<?php

declare(strict_types=1);

use function Flow\ETL\DSL\{df, from_rows, int_entry, min, ref, row, rows, to_output};

require __DIR__ . '/../../../autoload.php';

df()
    ->from(from_rows(rows(
        row(int_entry('a', 100)),
        row(int_entry('a', 100)),
        row(int_entry('a', 200)),
        row(int_entry('a', 400)),
        row(int_entry('a', 400))
    )))
    ->aggregate(min(ref('a')))
    ->write(to_output(false))
    ->run();

// +-------+
// | a_min |
// +-------+
// |   100 |
// +-------+
// 1 rows
