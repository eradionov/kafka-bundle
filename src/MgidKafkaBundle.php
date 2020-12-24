<?php declare(strict_types=1);

namespace Mgid\KafkaBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

final class MgidKafkaBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function getContainerExtension(): DependencyInjection\KafkaExtension
    {
        return new DependencyInjection\KafkaExtension();
    }
}
