<?php

namespace Egeniq\Monolog\Gdpr\Processor;

abstract class AbstractProcessor
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

    abstract public function __invoke(array $record): array;

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
