<?php declare(strict_types=1);

namespace Mgid\KafkaBundle\Tests\DependencyInjection\Traits;

use Mgid\KafkaBundle\Tests\Fixtures\DependencyInjection\Traits\LoggerFixture;
use Mgid\KafkaBundle\Tests\TestCase;
use Psr\Log\LoggerInterface;

final class LoggerTraitTest extends TestCase
{
    public function testAutowiring()
    {
        $fixture = $this->container->get(LoggerFixture::class);

        $this->assertInstanceOf(LoggerInterface::class, $fixture->getLogger());
    }
}
