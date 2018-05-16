<?php

namespace Anse\Monolog\Gdpr\Processor;

class RedactEmailProcessor extends AbstractProcessor
{
    /**
     * @param array $record
     *
     * @return array
     */
    public function __invoke(array $record): array
    {
        // serialise to a JSON string so we can scan the entire tree
        $serialised = json_encode($record);

        $filtered = preg_replace_callback(
            "/([a-z0-9!#$%&'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+\/=?^_`\"\"{|}~-]+)*(@|\sat\s)(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?(\.|\"\"\sdot\s))+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?)/",
            function ($matches) {
                return $this->getHashedValue($matches[0]);
            },
            $serialised
        );

        if ($filtered) {
            return json_decode($filtered, true);
        }

        return $record;
    }
}
