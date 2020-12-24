<?php declare(strict_types=1);

namespace Mgid\KafkaBundle\Tests\Fixtures\DependencyInjection\Traits;

use Mgid\KafkaBundle\DependencyInjection\Traits\ProducerTrait;
use Mgid\KafkaBundle\Producer\Producer;

final class ProducerFixture
{
    use ProducerTrait;

    public function getProducer(): Producer
    {
        return $this->producer;
    }
}
