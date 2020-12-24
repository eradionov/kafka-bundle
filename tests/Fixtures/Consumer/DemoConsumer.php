<?php declare(strict_types=1);

namespace Mgid\KafkaBundle\Tests\Fixtures\Consumer;

use Mgid\KafkaBundle\Command\Consumer;
use RdKafka\Message;

final class DemoConsumer extends Consumer
{
    public const QUEUE_NAME = 'test_demo';

    protected function handle(Message $message): void
    {
        $message->err = $this->getPayload($message)['code'];

        parent::handle($message);
    }

    protected function onMessage(array $data): void
    {
        if (isset($data['exception'])) {
            throw new \Exception('Test exception');
        }

        $this->logger->debug('success');
    }
}
