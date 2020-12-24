<?php declare(strict_types=1);

namespace Mgid\KafkaBundle\Tests\Consumer;

use Mgid\KafkaBundle\Exception\UnableProduceException;
use Mgid\KafkaBundle\Producer\Producer;
use Mgid\KafkaBundle\Tests\Fixtures\Consumer\DemoConsumer;
use Mgid\KafkaBundle\Tests\TestCase;
use Symfony\Component\Console;

final class DemoConsumerTest extends TestCase
{
    private Console\Tester\CommandTester $tester;

    protected function setUp(): void
    {
        parent::setUp();

        $consumer = $this->getDemoConsumer();
        $application = new Console\Application();
        $application->add($consumer);

        $this->tester = new Console\Tester\CommandTester($application->find($consumer->getName()));
    }

    public function testConsumerName(): void
    {
        $this->assertSame(
            'mgid:kafka-bundle:tests:fixtures:consumer:demo',
            $this->getDemoConsumer()->getName()
        );
    }

    public function testProduceConsume(): void
    {
        foreach ($this->getMessages() as $message) {
            $this->container->get(Producer::class)->send(DemoConsumer::QUEUE_NAME, $message);
        }

        $this->executeConsumer();

        $this->assertSame($this->getExpectedLoggerMessages(), $this->container->get('logger')->messages);
    }

    public function testProduceFlushException(): void
    {
        $this->expectException(UnableProduceException::class);

        $this->container->get(Producer::class)->send(__FUNCTION__, [], 0);
    }

    private function getMessages(): array
    {
        return [
            ['payload' => 'no-error', 'code' => \RD_KAFKA_RESP_ERR_NO_ERROR],
            ['exception' => true, 'code' => \RD_KAFKA_RESP_ERR_NO_ERROR],
            ['payload' => 'timed-out', 'code' => \RD_KAFKA_RESP_ERR__TIMED_OUT],
            ['payload' => 'partition-eof', 'code' => \RD_KAFKA_RESP_ERR__PARTITION_EOF],
            ['payload' => 'bad-compression', 'code' => \RD_KAFKA_RESP_ERR__BAD_COMPRESSION],
        ];
    }

    private function getExpectedLoggerMessages(): array
    {
        return [
            'debug' => [
                [
                    'message' => 'success',
                    'context' => [],
                ],
                [
                    'message' => 'Local: Timed out',
                    'context' => ['code' => \RD_KAFKA_RESP_ERR__TIMED_OUT],
                ],
                [
                    'message' => 'Broker: No more messages',
                    'context' => ['code' => \RD_KAFKA_RESP_ERR__PARTITION_EOF],
                ],
            ],
            'error' => [
                [
                    'message' => 'Test exception',
                    'context' => ['payload' => '{"exception":true,"code":0}'],
                ],
                [
                    'message' => 'Local: Invalid compressed data',
                    'context' => [
                        'code' => \RD_KAFKA_RESP_ERR__BAD_COMPRESSION,
                        'payload' => '{"payload":"bad-compression","code":-198}',
                    ],
                ],
            ],
            'info' => [
                [
                    'message' => 'Process termination',
                    'context' => [
                        'signal' => \RD_KAFKA_RESP_ERR__BAD_COMPRESSION,
                    ],
                ],
            ],
        ];
    }

    private function getDemoConsumer(): DemoConsumer
    {
        return $this->container->get(DemoConsumer::class);
    }

    private function executeConsumer(): void
    {
        $this->tester->execute([]);
    }
}
