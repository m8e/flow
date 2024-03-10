<?php

declare(strict_types=1);
namespace Flow\Parquet\Thrift;

/**
 * Autogenerated by Thrift Compiler (0.19.0).
 *
 * DO NOT EDIT UNLESS YOU ARE SURE THAT YOU KNOW WHAT YOU ARE DOING
 *
 *  @generated
 */

/**
 * Enum to annotate whether lists of min/max elements inside ColumnIndex
 * are ordered and if so, in which direction.
 */
final class BoundaryOrder
{
    public const ASCENDING = 1;

    public const DESCENDING = 2;

    public const UNORDERED = 0;

    public static $__names = [
        0 => 'UNORDERED',
        1 => 'ASCENDING',
        2 => 'DESCENDING',
    ];
}
