<?php declare(strict_types=1);

namespace Mgid\KafkaBundle\Tests\DependencyInjection\Traits;

use Mgid\KafkaBundle\Producer\Producer;
use Mgid\KafkaBundle\Tests\Fixtures\DependencyInjection\Traits\ProducerFixture;
use Mgid\KafkaBundle\Tests\TestCase;

final class ProducerTraitTest extends TestCase
{
    public function testAutowiring()
    {
        $fixture = $this->container->get(ProducerFixture::class);

        $this->assertInstanceOf(Producer::class, $fixture->getProducer());
    }
}
