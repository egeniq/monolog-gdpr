<?php

namespace Anse\Monolog\Gdpr\Processor;

class RedactIpProcessor extends AbstractProcessor
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
            "/(\b\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3}\b)/",
            function($matches) {
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
