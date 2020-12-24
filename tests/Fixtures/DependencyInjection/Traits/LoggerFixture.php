<?php declare(strict_types=1);

namespace Mgid\KafkaBundle\Tests\Fixtures\DependencyInjection\Traits;

use Mgid\KafkaBundle\DependencyInjection\Traits\LoggerTrait;
use Psr\Log\LoggerInterface;

final class LoggerFixture
{
    use LoggerTrait;

    public function getLogger(): LoggerInterface
    {
        return $this->logger;
    }
}
