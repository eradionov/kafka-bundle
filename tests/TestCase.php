<?php declare(strict_types=1);

namespace Mgid\KafkaBundle\Tests;

use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    protected ContainerInterface $container;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->container = Kernel::make()->getContainer();
    }
}
