<?php

declare(strict_types=1);

namespace Egeniq\Monolog\Gdpr\Processor;

class RedactEmailProcessor extends AbstractProcessor
{
    protected const REGEX_PATTERN = "/([a-z0-9!#$%&'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+\/=?^_`\"\"{|}~-]+)*(@|\sat\s)(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?(\.|\"\"\sdot\s))+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?)/";
}
