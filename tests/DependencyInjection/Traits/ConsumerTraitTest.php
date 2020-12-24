<?php declare(strict_types=1);

namespace Mgid\KafkaBundle\Tests\DependencyInjection\Traits;

use Mgid\KafkaBundle\Consumer\Consumer;
use Mgid\KafkaBundle\Tests\Fixtures\DependencyInjection\Traits\ConsumerFixture;
use Mgid\KafkaBundle\Tests\TestCase;

final class ConsumerTraitTest extends TestCase
{
    public function testAutowiring()
    {
        $fixture = $this->container->get(ConsumerFixture::class);

        $this->assertInstanceOf(Consumer::class, $fixture->getConsumer());
    }
}
