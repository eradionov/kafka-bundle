<?php declare(strict_types=1);

namespace Mgid\KafkaBundle\DependencyInjection;

use Mgid\KafkaBundle\Consumer;
use Mgid\KafkaBundle\Producer;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;

final class KafkaExtension extends ConfigurableExtension
{
    public const EXTENSION_ALIAS = 'mgid_kafka';

    /**
     * {@inheritdoc}
     */
    public function getAlias(): string
    {
        return self::EXTENSION_ALIAS;
    }

    /**
     * @param array<string,array> $configs
     * @param ContainerBuilder    $container
     */
    protected function loadInternal(array $configs, ContainerBuilder $container): void
    {
        $this->addConfiguration(Consumer\Configuration::class, $configs['consumers']['configuration'], $container);
        $this->addConfiguration(Producer\Configuration::class, $configs['producers']['configuration'], $container);

        $this->addServiceDefinition(Consumer\Consumer::class, Consumer\Configuration::class, $container);
        $this->addServiceDefinition(Producer\Producer::class, Producer\Configuration::class, $container);
    }

    /**
     * @param string              $id
     * @param array<string,mixed> $configs
     * @param ContainerBuilder    $container
     */
    private function addConfiguration(string $id, array $configs, ContainerBuilder $container): void
    {
        $container->setDefinition($id, new Definition($id, [$configs]));
    }

    /**
     * @param string           $id
     * @param string           $configClassName
     * @param ContainerBuilder $container
     */
    private function addServiceDefinition(string $id, string $configClassName, ContainerBuilder $container): void
    {
        $definition = new Definition($id, [new Reference($configClassName)]);
        $definition->setPublic(true);
        $definition->setAutowired(true);
        $definition->setAutoconfigured(true);

        $container->setDefinition($id, $definition);
    }
}
