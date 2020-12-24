<?php declare(strict_types=1);

namespace Mgid\KafkaBundle\Producer;

use JsonException;
use Mgid\KafkaBundle\Exception\UnableProduceException;

final class Producer
{
    public const DEFAULT_TIMEOUT = 1000;
    public const FLUSH_RETRY_COUNT = 10;

    private Configuration $configuration;

    /**
     * @var \RdKafka\ProducerTopic[]
     */
    private array $topics = [];

    /**
     * @param Configuration $configuration
     */
    public function __construct(Configuration $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * @param string       $name
     * @param array<mixed> $data
     * @param int          $timeout
     *
     * @throws JsonException
     * @throws UnableProduceException
     */
    public function send(string $name, array $data, int $timeout = self::DEFAULT_TIMEOUT): void
    {
        $payload = \json_encode($data, \JSON_THROW_ON_ERROR);

        $this->getTopic($name)->produce(\RD_KAFKA_PARTITION_UA, 0, $payload);

        for ($i = 0; $i < self::FLUSH_RETRY_COUNT; ++$i) {
            if (\RD_KAFKA_RESP_ERR_NO_ERROR === $this->getClient()->flush($timeout)) {
                return;
            }
        }

        throw new UnableProduceException($payload);
    }

    /**
     * @return \RdKafka\Producer
     */
    private function getClient(): \RdKafka\Producer
    {
        static $client = null;

        if (null === $client) {
            $client = new \RdKafka\Producer($this->configuration);
        }

        return $client;
    }

    /**
     * @param string $name
     *
     * @return \RdKafka\ProducerTopic
     */
    private function getTopic(string $name): \RdKafka\ProducerTopic
    {
        if (false === isset($this->topics[$name])) {
            $this->topics[$name] = $this->getClient()->newTopic($name);
        }

        return $this->topics[$name];
    }
}
