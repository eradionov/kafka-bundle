<?php declare(strict_types=1);

namespace Mgid\KafkaBundle\DependencyInjection\Traits;

use Mgid\KafkaBundle\Producer\Producer;

trait ProducerTrait
{
    protected Producer $producer;

    /**
     * @required
     *
     * @param Producer $producer
     */
    public function setProducer(Producer $producer): void
    {
        $this->producer = $producer;
    }
}
