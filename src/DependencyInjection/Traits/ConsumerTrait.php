<?php declare(strict_types=1);

namespace Mgid\KafkaBundle\DependencyInjection\Traits;

use Mgid\KafkaBundle\Consumer\Consumer;

trait ConsumerTrait
{
    protected Consumer $consumer;

    /**
     * @required
     *
     * @param Consumer $consumer
     */
    public function setConsumer(Consumer $consumer): void
    {
        $this->consumer = $consumer;
    }
}
