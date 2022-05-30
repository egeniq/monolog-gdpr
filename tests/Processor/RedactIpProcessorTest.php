<?php

namespace Egeniq\Monolog\Gdpr\Processor;

use Monolog\Handler\TestHandler;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;

class RedactIpProcessorTest extends TestCase
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
        $this->processor = new RedactIpProcessor();

        $this->handler = new TestHandler();
        $this->logger = new Logger('test', [$this->handler]);
        $this->logger->pushProcessor($this->processor);

        parent::setUp();
    }

    public function testIpIsRedacted()
    {
        $this->logger->log(Logger::DEBUG, 'This is a test for 127.0.0.1', ['foo' => ['bar' => '127.0.0.1']]);
        $records = $this->handler->getRecords();

        $this->assertEquals('This is a test for 4b84b15bff6ee5796152495a230e45e3d7e947d9', $records[0]['message']);
        $this->assertEquals(
            [
                'foo' => [
                    'bar' => '4b84b15bff6ee5796152495a230e45e3d7e947d9'
                ]
            ],
            $records[0]['context']
        );
    }

    public function testIpIsRedactedAndSalted()
    {
        $this->processor->setSalt('h@tsefl@ts!');

        $this->logger->log(Logger::DEBUG, 'This is a test for 127.0.0.1', ['foo' => ['bar' => '127.0.0.1']]);
        $records = $this->handler->getRecords();

        $this->assertEquals('This is a test for d0821e9da4f151084b4ab5f7d000f3813a578e49', $records[0]['message']);
        $this->assertEquals(
            [
                'foo' => [
                    'bar' => 'd0821e9da4f151084b4ab5f7d000f3813a578e49'
                ]
            ],
            $records[0]['context']
        );
    }
}
