<?php declare(strict_types=1);

namespace Mgid\KafkaBundle\Tests\Fixtures\DependencyInjection\Traits;

use Mgid\KafkaBundle\Consumer\Consumer;
use Mgid\KafkaBundle\DependencyInjection\Traits\ConsumerTrait;

final class ConsumerFixture
{
    use ConsumerTrait;

    public function getConsumer(): Consumer
    {
        return $this->consumer;
    }
}
