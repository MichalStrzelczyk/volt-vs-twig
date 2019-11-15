<?php
declare (strict_types=1);

namespace Log;

class Formatter extends \Phalcon\Logger\Formatter\Syslog implements \Phalcon\Logger\FormatterInterface {
    /**
     * @var array
     */
    protected $types = [
        \Phalcon\Logger::EMERGENCY => 'EMERGENCY',
        \Phalcon\Logger::CRITICAL => 'CRITICAL',
        \Phalcon\Logger::ALERT => 'ALERT',
        \Phalcon\Logger::ERROR => 'ERROR',
        \Phalcon\Logger::WARNING => 'WARNING',
        \Phalcon\Logger::NOTICE => 'NOTICE',
        \Phalcon\Logger::INFO => 'INFO',
        \Phalcon\Logger::DEBUG => 'DEBUG',
        \Phalcon\Logger::CUSTOM => 'CUSTOM',
    ];

    /**
     * @param string $message
     * @param int $type
     * @param int $timestamp
     * @param null $context
     *
     * @return array|string
     */
    public function format($message, $type, $timestamp, $context = null){
        $errorLevel = $this->types[$type];
        return parent::format("[$errorLevel] ".$message, $type, $timestamp, $context);
    }
}