<?php

namespace Egeniq\Monolog\Gdpr\Processor;

use Monolog\Handler\TestHandler;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;

class RedactEmailProcessorTest extends TestCase
{
    /**
     * @var TestHandler
     */
    private $handler;

    /**
     * @var Logger
     */
    private $logger;

    /**
     * @var RedactEmailProcessor
     */
    private $processor;

    public function setUp(): void
    {
        $this->processor = new RedactEmailProcessor();

        $this->handler = new TestHandler();
        $this->logger = new Logger('test', [$this->handler]);
        $this->logger->pushProcessor($this->processor);

        parent::setUp();
    }

    public function testEmailIsRedacted()
    {
        $this->logger->log(Logger::DEBUG, 'This is a test for foo@bar.com', ['foo' => ['bar' => 'foo@bar.com']]);
        $records = $this->handler->getRecords();

        $this->assertEquals('This is a test for 823776525776c8f23a87176c59d25759da7a52c4', $records[0]['message']);
        $this->assertEquals(
            [
                'foo' => [
                    'bar' => '823776525776c8f23a87176c59d25759da7a52c4'
                ]
            ],
            $records[0]['context']
        );
    }

    public function testEmailIsRedactedAndSalted()
    {
        $this->processor->setSalt('h@tsefl@ts!');

        $this->logger->log(Logger::DEBUG, 'This is a test for foo@bar.com', ['foo' => ['bar' => 'foo@bar.com']]);
        $records = $this->handler->getRecords();

        $this->assertEquals('This is a test for 04a0efd2d95b09e74db7add638e48931ce242867', $records[0]['message']);
        $this->assertEquals(
            [
                'foo' => [
                    'bar' => '04a0efd2d95b09e74db7add638e48931ce242867'
                ]
            ],
            $records[0]['context']
        );
    }

    public function testEmailIsRedactedInProblematicString()
    {
        $this->logger->log(Logger::DEBUG, '(1,	\'foo@bar.com\')', ['foo' => ['bar' => 'foo@bar.com']]);
        $records = $this->handler->getRecords();

        $this->assertEquals('(1,	40d36e2e19ba403439bdf6ad32d294d530ff0ec7\')', $records[0]['message']);
        $this->assertEquals(
            [
                'foo' => [
                    'bar' => '823776525776c8f23a87176c59d25759da7a52c4'
                ]
            ],
            $records[0]['context']
        );
    }
}
