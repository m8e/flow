<?php

declare(strict_types=1);

use function Flow\ETL\DSL\{data_frame, from_sequence_date_period, to_output};

require __DIR__ . '/../../../autoload.php';

data_frame()
    ->read(from_sequence_date_period(
        'date',
        new DateTimeImmutable('now'),
        new DateInterval('P1D'),
        new DateTimeImmutable('now + 60 days'),
    ))
    ->write(to_output(false))
    ->run();
