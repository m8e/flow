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
use Thrift\Base\TBase;
use Thrift\Type\TType;

/**
 * Data page header.
 */
class DataPageHeader extends TBase
{
    public static $_TSPEC = [
        1 => [
            'var' => 'num_values',
            'isRequired' => true,
            'type' => TType::I32,
        ],
        2 => [
            'var' => 'encoding',
            'isRequired' => true,
            'type' => TType::I32,
            'class' => '\Flow\Parquet\Thrift\Encoding',
        ],
        3 => [
            'var' => 'definition_level_encoding',
            'isRequired' => true,
            'type' => TType::I32,
            'class' => '\Flow\Parquet\Thrift\Encoding',
        ],
        4 => [
            'var' => 'repetition_level_encoding',
            'isRequired' => true,
            'type' => TType::I32,
            'class' => '\Flow\Parquet\Thrift\Encoding',
        ],
        5 => [
            'var' => 'statistics',
            'isRequired' => false,
            'type' => TType::STRUCT,
            'class' => '\Flow\Parquet\Thrift\Statistics',
        ],
    ];

    public static $isValidate = false;

    /**
     * Encoding used for definition levels *.
     *
     * @var int
     */
    public $definition_level_encoding;

    /**
     * Encoding used for this data page *.
     *
     * @var int
     */
    public $encoding;

    /**
     * Number of values, including NULLs, in this data page. *.
     *
     * @var int
     */
    public $num_values;

    /**
     * Encoding used for repetition levels *.
     *
     * @var int
     */
    public $repetition_level_encoding;

    /**
     * Optional statistics for the data in this page*.
     *
     * @var Statistics
     */
    public $statistics;

    public function __construct($vals = null)
    {
        if (\is_array($vals)) {
            parent::__construct(self::$_TSPEC, $vals);
        }
    }

    public function getName()
    {
        return 'DataPageHeader';
    }

    public function read($input)
    {
        return $this->_read('DataPageHeader', self::$_TSPEC, $input);
    }

    public function write($output)
    {
        return $this->_write('DataPageHeader', self::$_TSPEC, $output);
    }
}
