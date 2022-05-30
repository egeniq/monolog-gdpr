<?php

declare(strict_types=1);

namespace Egeniq\Monolog\Gdpr\Processor;

class RedactIpProcessor extends AbstractProcessor
{
    protected const REGEX_PATTERN = "/(\b\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3}\b)/";
}
