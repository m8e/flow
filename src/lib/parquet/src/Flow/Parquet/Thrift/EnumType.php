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

class EnumType extends TBase
{
    public static $_TSPEC = [
    ];

    public static $isValidate = false;

    public function __construct()
    {
    }

    public function getName()
    {
        return 'EnumType';
    }

    public function read($input)
    {
        return $this->_read('EnumType', self::$_TSPEC, $input);
    }

    public function write($output)
    {
        return $this->_write('EnumType', self::$_TSPEC, $output);
    }
}
