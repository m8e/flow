<?php declare(strict_types=1);
namespace Flow\Parquet\Thrift;

/**
 * Autogenerated by Thrift Compiler (0.19.0).
 *
 * DO NOT EDIT UNLESS YOU ARE SURE THAT YOU KNOW WHAT YOU ARE DOING
 *
 *  @generated
 */
use Thrift\Base\TBase;

/**
 * Hash strategy type annotation. xxHash is an extremely fast non-cryptographic hash
 * algorithm. It uses 64 bits version of xxHash.
 */
class XxHash extends TBase
{
    public static $_TSPEC = [
    ];

    public static $isValidate = false;

    public function __construct()
    {
    }

    public function getName()
    {
        return 'XxHash';
    }

    public function read($input)
    {
        return $this->_read('XxHash', self::$_TSPEC, $input);
    }

    public function write($output)
    {
        return $this->_write('XxHash', self::$_TSPEC, $output);
    }
}