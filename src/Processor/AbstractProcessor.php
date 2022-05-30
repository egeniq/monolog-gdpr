<?php

declare(strict_types=1);

namespace Egeniq\Monolog\Gdpr\Processor;

use Monolog\Processor\ProcessorInterface;

abstract class AbstractProcessor implements ProcessorInterface
{
    private string $salt = '';

    public function setSalt(string $salt): void
    {
        $this->salt = $salt;
    }

    /**
     * NOTE: the signature of this method will change when support for Monolog 3 is added.
     */
    public function __invoke(array $record): array
    {
        return $this->redactValuesRecursively($record);
    }

    private function redactValuesRecursively(array $record): array
    {
        foreach ($record as $key => $value) {
            if (is_string($value)) {
                $record[$key] = $this->redactStringValue($value);
            } elseif (is_array($value)) {
                $record[$key] = $this->redactValuesRecursively($value);
            }
        }

        return $record;
    }

    private function redactStringValue(string $record): string
    {
        return preg_replace_callback(
            static::REGEX_PATTERN,
            function (array $matches): string {
                return $this->getHashedValue($matches[0]);
            },
            $record
        ) ?? $record;
    }

    private function getHashedValue(string $value): string
    {
        return sha1($value . $this->salt);
    }
}
