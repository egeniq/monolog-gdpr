<?php

namespace Egeniq\Monolog\Gdpr\Processor;

use Monolog\Processor\ProcessorInterface;

abstract class AbstractProcessor implements ProcessorInterface
{
    /**
     * @var null|string
     */
    private $salt;

    /**
     * @param string $salt
     */
    public function setSalt(string $salt): void
    {
        $this->salt = $salt;
    }

    /**
     * @param string $value
     *
     * @return string
     */
    protected function getHashedValue(string $value)
    {
        return sha1($value . $this->salt);
    }
}
